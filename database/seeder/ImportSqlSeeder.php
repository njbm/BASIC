<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportSqlSeeder extends Seeder
{
    public function run(): void
    {
        $sqlFiles = [
            //'languages' => database_path('sql/languages.sql'),
            'notification_templates' => database_path('sql/notification_templates.sql'),
        ];

        foreach ($sqlFiles as $tableName => $filePath) {
            if (Schema::hasTable($tableName)) {
                Schema::drop($tableName);
                $this->command->warn("Table '$tableName' dropped successfully.");
            }
            if (file_exists($filePath)) {
                DB::unprepared(file_get_contents($filePath));
                $this->command->info("SQL file '$filePath' for table '$tableName' imported successfully.");
            } else {
                $this->command->error("SQL file not found: $filePath");
            }
        }



        //single file
        /*$tableName = 'pages';
        $sqlFile = database_path('sql/pages.sql');
        if (Schema::hasTable($tableName)) {
            Schema::drop($tableName);
            $this->command->warn("Table '$tableName' dropped successfully.");
        }
        if (file_exists($sqlFile)) {
            DB::unprepared(file_get_contents($sqlFile));
            $this->command->info("SQL file '$sqlFile' imported successfully.");
        } else {
            $this->command->error("SQL file not found: $sqlFile");
        }*/


    }
}
