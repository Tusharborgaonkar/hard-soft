import os
import sys
import mysql.connector
import pandas as pd
from rapidfuzz import process, fuzz
import unicodedata
import argparse
import subprocess
from datetime import datetime
from dotenv import load_dotenv
import logging
import json

# Setup logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler("db_standardize.log"),
        logging.StreamHandler(sys.stdout)
    ]
)

def load_db_config():
    """Loads database configuration from .env file."""
    load_dotenv()
    return {
        'host': os.getenv('DB_HOST', '127.0.0.1'),
        'user': os.getenv('DB_USERNAME', 'root'),
        'password': os.getenv('DB_PASSWORD', ''),
        'database': os.getenv('DB_DATABASE', 'soft-hard-final'),
        'port': os.getenv('DB_PORT', '3306')
    }

def create_backup(config):
    """Creates a database backup using mysqldump."""
    timestamp = datetime.now().strftime('%Y%m%d_%H%M%S')
    backup_file = f"backup_{config['database']}_{timestamp}.sql"
    
    # Construct mysqldump command
    # Note: Password in command line is generally unsafe but often necessary for scripts
    # We use -p with no space if password exists
    cmd = [
        'mysqldump',
        '-h', config['host'],
        '-P', config['port'],
        '-u', config['user'],
    ]
    
    if config['password']:
        cmd.append(f"--password={config['password']}")
    
    cmd.extend([config['database'], '--result-file=' + backup_file])
    
    logging.info(f"Creating database backup: {backup_file}...")
    try:
        subprocess.run(cmd, check=True)
        logging.info("Backup created successfully.")
        return backup_file
    except subprocess.CalledProcessError as e:
        logging.error(f"Backup failed: {e}")
        # In a real production environment, we might want to stop here
        return None

def normalize_gujarati(text):
    """Normalizes Gujarati Unicode text."""
    if not isinstance(text, str):
        return text
    # NFC normalization for consistent representation
    text = unicodedata.normalize('NFC', text)
    return text.strip()

def get_unique_values(conn, table, column):
    """Fetches unique values from the specified table and column."""
    cursor = conn.cursor()
    query = f"SELECT DISTINCT {column} FROM {table} WHERE {column} IS NOT NULL AND {column} != ''"
    cursor.execute(query)
    values = [row[0] for row in cursor.fetchall()]
    cursor.close()
    return values

def find_similar_groups(values, threshold=90):
    """Groups similar values using fuzzy matching."""
    unique_normalized = list(set([normalize_gujarati(v) for v in values]))
    mappings = {}
    processed = set()

    for val in unique_normalized:
        if val in processed:
            continue
            
        # SAFETY FILTER: Skip IDs, Tags, and JSON data
        # We only want to clean real Gujarati text.
        if val.startswith('[') or val.startswith('{') or val.isdigit():
            processed.add(val)
            continue
        
        # Find matches for this value among others
        matches = process.extract(
            val, 
            [v for v in unique_normalized if v != val and v not in processed],
            scorer=fuzz.ratio,
            score_cutoff=threshold
        )
        
        if matches:
            # We found similar values. Let the first one be the "standard"
            # In a more advanced version, we could pick the most frequent one
            group = [val] + [m[0] for m in matches]
            standard = val # Default standard
            
            for item in group:
                mappings[item] = standard
                processed.add(item)
        else:
            processed.add(val)
            
    return mappings

def apply_updates(conn, table, column, mappings, dry_run=True):
    """Applies the mappings to the database."""
    cursor = conn.cursor()
    total_affected = 0
    
    report = []

    for old_val, new_val in mappings.items():
        if old_val == new_val:
            continue
            
        # Count how many records will be changed
        count_query = f"SELECT COUNT(*) FROM {table} WHERE {column} = %s"
        cursor.execute(count_query, (old_val,))
        count = cursor.fetchone()[0]
        
        if count > 0:
            total_affected += count
            report.append({
                'Old Value': old_val,
                'New Value': new_val,
                'Count': count
            })
            
            if not dry_run:
                update_query = f"UPDATE {table} SET {column} = %s WHERE {column} = %s"
                cursor.execute(update_query, (new_val, old_val))
                logging.info(f"Updated {count} rows: '{old_val}' -> '{new_val}'")

    if not dry_run:
        conn.commit()
        logging.info(f"Committed changes. Total rows affected: {total_affected}")
    else:
        logging.info(f"Dry run complete. Total rows that would be affected: {total_affected}")

    cursor.close()
    return report

def main():
    parser = argparse.ArgumentParser(description='Standardize Gujarati text in MySQL database.')
    parser.add_argument('--table', default='answers', help='Table to scan')
    parser.add_argument('--column', default='answer_value', help='Column to scan')
    parser.add_argument('--threshold', type=int, default=85, help='Fuzzy matching threshold (0-100)')
    parser.add_argument('--update', action='store_true', help='Apply changes to database (else dry-run)')
    parser.add_argument('--no-backup', action='store_true', help='Skip backup creation')
    
    args = parser.parse_args()
    
    config = load_db_config()
    
    try:
        conn = mysql.connector.connect(
            host=config['host'],
            user=config['user'],
            password=config['password'],
            database=config['database'],
            port=config['port']
        )
        logging.info(f"Connected to database: {config['database']}")
    except mysql.connector.Error as err:
        logging.error(f"Error: {err}")
        return

    # 1. Backup
    if args.update and not args.no_backup:
        create_backup(config)

    # 2. Fetch Values
    logging.info(f"Fetching unique values from {args.table}.{args.column}...")
    values = get_unique_values(conn, args.table, args.column)
    logging.info(f"Found {len(values)} unique values.")

    # 3. Find Mappings
    logging.info(f"Detecting similar Gujarati spellings (threshold={args.threshold})...")
    # Add manual mappings as requested
    manual_mappings = {
        "હિંદુ": "હિન્દુ",
        "હિંદુ કડવા પાટીદાર": "હિન્દુ કડવા પાટીદાર"
    }
    
    # Detect automatic mappings
    auto_mappings = find_similar_groups(values, threshold=args.threshold)
    
    # Merge mappings (manual takes precedence if needed, but here we just merge)
    final_mappings = {**auto_mappings, **manual_mappings}
    
    # 4. Report / Update
    logging.info("Generating report...")
    report = apply_updates(conn, args.table, args.column, final_mappings, dry_run=not args.update)
    
    if report:
        df = pd.DataFrame(report)
        print("\n--- STANDARDIZATION REPORT ---")
        print(df.to_string(index=False))
        df.to_csv("standardization_report.csv", index=False, encoding='utf-8-sig')
        logging.info("Full report saved to standardization_report.csv")
    else:
        logging.info("No inconsistent values detected to standardize.")

    conn.close()

if __name__ == "__main__":
    main()
