<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CopyTableData extends Command
{
    protected $signature = 'db:copy-table-data';
    protected $description = 'Copy data from source_db to default DB';

    public function handle()
    {
        $tables = [
//            'file_storages',
//            'manual_sms_configs',
//            'gateways',
//            'payout_methods',
//            'maintenance_modes',
//
//            'kycs',
//
//            'badges',
//            'faqs',
//            'plans',
//
//            'help_sections',
//            'help_articles',

//            'blog_categories',
//            'blogs',
//            'blog_details',
        ];

        foreach ($tables as $table) {
            $this->info("Copying: $table");

            $sourceData = DB::connection('source_db')->table($table)->get();

            foreach ($sourceData as $row) {
                DB::table($table)->insert((array) $row);
            }

            $this->info("Done: $table");
        }

        $this->info('All tables copied successfully.');
    }
}





// ****requirements****

// config/database.php
// after 'mysql'=>[],

//         'source_db' => [
//             'driver' => 'mysql',
//             'url' => env('SOURCE_DATABASE_URL'),
//             'host' => env('SOURCE_DB_HOST', '127.0.0.1'),
//             'port' => env('SOURCE_DB_PORT', '3306'),
//             'database' => env('SOURCE_DB_DATABASE', 'forge'),
//             'username' => env('SOURCE_DB_USERNAME', 'forge'),
//             'password' => env('SOURCE_DB_PASSWORD', ''),
//             'unix_socket' => env('SOURCE_DB_SOCKET', ''),
//             'charset' => 'utf8mb4',
//             'collation' => 'utf8mb4_unicode_ci',
//             'prefix' => '',
//             'prefix_indexes' => true,
//             'strict' => false,
//             'engine' => null,
//             'options' => extension_loaded('pdo_mysql') ? array_filter([
//                 PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
//             ]) : [],
//         ],


//         .env
//         # Source DB (old project like Digitmart)
// SOURCE_DB_HOST=127.0.0.1
// SOURCE_DB_PORT=3306
// SOURCE_DB_DATABASE=test_new
// SOURCE_DB_USERNAME=root
// SOURCE_DB_PASSWORD=


