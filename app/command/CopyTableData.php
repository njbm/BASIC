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
