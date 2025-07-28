<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Product;
use App\Models\PageSeo;
use Illuminate\Support\Str;
use Throwable;

class PageSeoSeeder extends Seeder
{
    public function run()
    {
        $basic = basicControl();
        $siteTitle = siteTitle();

        DB::beginTransaction();

        try {
            Page::chunk(100, function ($pages) use ($siteTitle) {
                foreach ($pages as $page) {
                    PageSeo::updateOrCreate(
                        [
                            'seoable_id' => $page->id,
                            'seoable_type' => get_class($page),
                        ],
                        [
                            'page_title' => ucfirst($page->name),
                            'meta_title' => "$siteTitle: Buy Digital Content Online",
                            'meta_keywords' => ["digital content", "online sale", "script", "ebooks", "download", "purchase"],
                            'meta_description' => "Read the latest articles and updates at $siteTitle. Stay informed with valuable content and news.",
                            'og_description' => "Explore insightful content and news. Stay updated with the latest information from $siteTitle.",
                            'meta_robots' => 'index,follow',
                            'meta_image' => "seo/default.png",
                            'meta_image_driver' => "local",
                        ]
                    );
                }
            });

            Blog::with("details")->chunk(100, function ($blogs) use ($siteTitle) {
                foreach ($blogs as $blog) {
                    $description = $this->makeMetaOgDescription($blog->details?->description);
                    $metaDescription = $description['meta'];
                    $ogDescription = $description['og'];
                    PageSeo::updateOrCreate(
                        [
                            'seoable_id' => $blog->id,
                            'seoable_type' => get_class($blog),
                        ],
                        [
                            'page_title' => $blog->details?->title,
                            'meta_title' => $blog->details?->title,
                            'meta_keywords' => ["digital content", "online sale", "script", "ebooks", "download", "purchase"],
                            'meta_description' => $metaDescription,
                            'og_description' => $ogDescription,
                            'meta_robots' => 'index,follow',
                            'meta_image' => $blog->blog_image ?? "seo/default.png",
                            'meta_image_driver' => $blog->blog_image_driver ?? "local",
                        ]
                    );
                }
            });

            Product::chunk(100, function ($products) use ($siteTitle) {
                foreach ($products as $product) {
                    $description = $this->makeMetaOgDescription($product->description);
                    $metaDescription = $description['meta'];
                    $ogDescription = $description['og'];
                    PageSeo::updateOrCreate(
                        [
                            'seoable_id' => $product->id,
                            'seoable_type' => get_class($product),
                        ],
                        [
                            'page_title' => $product->title,
                            'meta_title' => $product->title,
                            'meta_keywords' => $product->tags,
                            'meta_description' => $metaDescription,
                            'og_description' => $ogDescription,
                            'meta_robots' => 'index,follow',
                            'meta_image' => $product->preview ?? "seo/default.png",
                            'meta_image_driver' => $product->preview_driver ?? "local",
                        ]
                    );
                }
            });

            DB::commit();
            $this->command->info('PageSeoSeeder successfully updated.');

        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('PageSeoSeeder Error: ' . $e->getMessage());
            $this->command->error('PageSeoSeeder Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function makeMetaOgDescription($description = null): array
    {
        if (is_null($description)) {
            return [
                'meta' => null,
                'og' => null
            ];
        }

        $productDescription = strip_tags($description);
        $baseDescription = Str::words($productDescription, 150);
        $keySentences = [
            'Explore the world of learning with our premium content.',
            'Start your journey of discovery today!',
            'Enjoy seamless access to top-quality digital content.',
        ];
        $randomSentence = $keySentences[array_rand($keySentences)];
        $metaDescription = $baseDescription . ' ' . $randomSentence;
        $ogDescription = $baseDescription;

        return [
            'meta' => $metaDescription,
            'og' => $ogDescription
        ];
    }

}


//open_ai_api_key = "sk-vnugZJN7DLxQoifJX6OAtqZ-7ZW3B0AtteP6q7eWrzT3BlbkFJtOEAhGtVXhxxWCnyWBcdGcn5ger0wkKVr2oNe5cKsA";
