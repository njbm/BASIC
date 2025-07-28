<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'is_owner' => 1,
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin'),
                'image' => null,
                'image_driver' => null,
                'phone' => '1234567890',
                'address' => 'Admin Headquarters, New York',
                'admin_access' => null,
                'last_login' => now()->toDateTimeString(),
                'last_seen' => now(),
                'status' => 1,
                'remember_token' => null,
            ]
        );

        Artisan::call('cache:clear');
    }
}
