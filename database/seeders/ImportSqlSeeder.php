<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class ImportSqlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = database_path('u362391755_hard_soft.sql');

        if (!File::exists($sqlPath)) {
            $this->command->error("SQL file not found at: {$sqlPath}");
            return;
        }

        $this->command->info("Starting SQL import from {$sqlPath}...");

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Drop all existing tables to allow SQL's CREATE TABLE statements to work
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $property = "Tables_in_{$dbName}";

        foreach ($tables as $table) {
            $tableName = $table->$property;
            Schema::dropIfExists($tableName);
        }

        // Read and execute SQL file
        $sql = File::get($sqlPath);
        
        // Execute the SQL as a single unprepared statement
        // Note: For very large files, this might need chunking, but 65KB is small enough.
        DB::unprepared($sql);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("SQL import completed successfully.");
    }
}
