<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ManageMenu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call(BasicControlSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(ManageMenuSeeder::class);


//        $this->call(ImportSqlSeeder::class);


    }
}
