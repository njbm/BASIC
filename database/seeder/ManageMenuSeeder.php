<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ManageMenu;

class ManageMenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            'spark' => [
                'header' => ['home', 'about', 'blogs', 'products', 'contact'],
                'footer' => [
                    'useful_link' => ['about', 'faq', 'contact', 'products', 'blogs'],
                    'support_link' => ['privacy policy', 'terms & conditions', 'cookie policy'],
                ],
            ],
            'orbit' => [
                'header' => ['home', 'about', 'blogs', 'products', 'contact'],
                'footer' => [
                    'useful_link' => ['about', 'faq', 'contact', 'products', 'blogs'],
                    'support_link' => ['privacy policy', 'terms & conditions', 'cookie policy'],
                ],
            ],
        ];

        foreach ($menus as $theme => $sections) {
            foreach ($sections as $section => $items) {
                ManageMenu::updateOrCreate(
                    ['theme' => $theme, 'menu_section' => $section],
                    ['menu_items' => $items]
                );
            }
        }
    }
}

