import mysql.connector
import os
import pandas as pd
import json
from dotenv import load_dotenv

load_dotenv()

class ReportEngine:
    def __init__(self):
        self.conn = mysql.connector.connect(
            host=os.getenv('DB_HOST', 'localhost'),
            user=os.getenv('DB_USERNAME', 'root'),
            password=os.getenv('DB_PASSWORD', ''),
            database=os.getenv('DB_DATABASE', 'soft-hard-final')
        )
        self.questions = self._get_questions()
        self.raw_data = self._get_raw_data()
        self.total_respondents = len(self.raw_data['response_id'].unique())
        
    def _get_questions(self):
        cur = self.conn.cursor(dictionary=True)
        cur.execute("SELECT id, question_text_gu, type FROM questions ORDER BY `order`")
        rows = cur.fetchall()
        cur.close()
        df = pd.DataFrame(rows)
        if df.empty: return {}
        return df.set_index('id').to_dict('index')

    def _get_raw_data(self):
        cur = self.conn.cursor(dictionary=True)
        cur.execute("SELECT response_id, question_id, answer_value FROM answers")
        rows = cur.fetchall()
        cur.close()
        return pd.DataFrame(rows)

    def pivot_data(self):
        """Pivots data so each response_id is a row and question_ids are columns."""
        df_pivot = self.raw_data.pivot(index='response_id', columns='question_id', values='answer_value')
        return df_pivot

    def get_taluka_group(self, row):
        """
        Determines the Taluka and Area (Rural/City) based on Question IDs 93-96.
        """
        taluka = str(row.get(95, '')).strip()
        village = str(row.get(93, '')).strip()
        city = str(row.get(94, '')).strip()
        
        # Clean common empty values
        empty_vals = ['', '-', 'None', 'nan', '.']
        
        if taluka in empty_vals:
            # Fallback to District/Village if Taluka is empty
            district = str(row.get(96, '')).strip()
            if "ગાંધીનગર" in district:
                taluka = "ગાંધીનગર"
            else:
                return "Unknown"
            
        if "ગાંધીનગર" in taluka:
            # Split Gandhinagar into Rural/City
            # If city field has content, it's City. Otherwise Rural.
            if city not in empty_vals and len(city) > 1:
                return "Gandhinagar (City)"
            else:
                return "Gandhinagar (Rural)"
        
        if "માણસા" in taluka: return "Mansa"
        if "કલોલ" in taluka: return "Kalol"
        if "દહેગામ" in taluka or "દેહગામ" in taluka: return "Dehgam"
        
        return "Other"

    def generate_stats(self, df_group):
        """Calculates stats for a given dataframe group."""
        stats = {}
        total_in_group = len(df_group)
        
        for q_id, q_meta in self.questions.items():
            if q_id not in df_group.columns:
                continue
                
            col_data = df_group[q_id]
            
            # Handle JSON/List answers (checkboxes)
            if q_meta['type'] == 'checkbox':
                # Flatten the list of lists
                all_options = []
                for val in col_data.dropna():
                    try:
                        parsed = json.loads(val)
                        if isinstance(parsed, list):
                            all_options.extend(parsed)
                    except:
                        pass
                counts = pd.Series(all_options).value_counts()
            else:
                counts = col_data.value_counts()

            # Convert to list of dicts for reporting
            q_stats = []
            for option, count in counts.items():
                q_stats.append({
                    "option": option,
                    "count": int(count),
                    "percentage": round((count / 330) * 100, 2) # Base 330 as requested
                })
            
            stats[q_id] = {
                "question": q_meta['question_text_gu'],
                "results": q_stats,
                "total_responses": int(counts.sum())
            }
            
        return stats

    def run(self):
        df = self.pivot_data()
        df['group'] = df.apply(self.get_taluka_group, axis=1)
        
        # 1. Individual Taluka Stats
        all_stats = {}
        for group_name in df['group'].unique():
            group_df = df[df['group'] == group_name]
            all_stats[group_name] = self.generate_stats(group_df)
            
        # 2. Combined Stats
        all_stats['Final Combined'] = self.generate_stats(df)
        
        return all_stats

if __name__ == "__main__":
    engine = ReportEngine()
    data = engine.run()
    # Save for preview
    with open("stats_data.json", "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=4)
    print("Stats generated successfully!")
