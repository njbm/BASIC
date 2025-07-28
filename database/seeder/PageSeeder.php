<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageDetail;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $themes = ['spark','orbit']; //,'orbit'
        $languageId = 1;

        $defaultPages = [
            ['name' => 'home', 'slug' => '/','type' => 0],
            ['name' => 'about', 'slug' => 'about','type' => 0],
            ['name' => 'faq', 'slug' => 'faq','type' => 0],
            ['name' => 'contact', 'slug' => 'contact','type' => 0],
            ['name' => 'pricing', 'slug' => 'pricing','type' => 0],
            ['name' => 'blogs', 'slug' => 'blogs'],
            ['name' => 'products', 'slug' => 'products'],
            ['name' => 'cookie policy', 'slug' => 'cookie-policy','type' => 0],
            ['name' => 'privacy policy', 'slug' => 'privacy-policy','type' => 0],
            ['name' => 'terms conditions', 'slug' => 'terms-conditions','type' => 0],
        ];

        foreach ($themes as $theme) {
            foreach ($defaultPages as $data) {
                $page = Page::updateOrCreate(
                    ['name' => $data['name'], 'template_name' => $theme],
                    [
                        'slug' => $data['slug'],
                        'type' => $data['type'] ?? 1,
                        'template_name' => $theme,
                    ]
                );

                PageDetail::updateOrCreate(
                    ['page_id' => $page->id, 'language_id' => $languageId],
                    [
                        'name' => Str::headline($page->name),
                        'content' => null,
                        'sections' => null,
                    ]
                );
            }
        }
    }
}

