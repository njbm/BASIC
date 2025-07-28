<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            [
                'name'           => 'English',
                'short_name'     => 'en',
                'flag'           => 'language/Tffwh41UiRo9GqB9P9OHiWP7R5lujb.avif',
                'flag_driver'    => 'local',
                'status'         => 1,
                'rtl'            => 0,
                'default_status' => 1,
            ],
            [
                'name'           => 'Spanish',
                'short_name'     => 'es',
                'flag'           => 'language/2NMm9l0d94BSpKWvJ4naT4W02i29Z6.avif',
                'flag_driver'    => 'local',
                'status'         => 1,
                'rtl'            => 0,
                'default_status' => 0,
            ],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(
                ['short_name' => $lang['short_name']],
                $lang
            );
        }
    }
}
