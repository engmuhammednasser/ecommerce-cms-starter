<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Home',
                'slug' => 'home',
                'content' => 'Welcome to the editable demo homepage.',
                'seo_title' => 'Demo Store Home',
                'seo_description' => 'A database-backed demo homepage for the Laravel ecommerce CMS starter kit.',
            ],
            [
                'title' => 'About',
                'slug' => 'about',
                'content' => 'This page can be edited from the admin CMS pages module.',
                'seo_title' => 'About Demo Store',
                'seo_description' => 'Learn about the demo store content managed from the dashboard.',
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'content' => 'Use the settings module to update store contact details.',
                'seo_title' => 'Contact Demo Store',
                'seo_description' => 'Contact page content for the editable demo store.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => 'Replace this placeholder policy with your real store privacy policy.',
                'seo_title' => 'Privacy Policy',
                'seo_description' => 'Demo privacy policy page.',
            ],
        ];

        foreach ($pages as $page) {
            Page::query()->updateOrCreate(
                ['slug' => $page['slug']],
                $page + [
                    'status' => 'published',
                    'seo_image' => 'demo/hero.svg',
                    'canonical_url' => null,
                    'meta_robots' => 'index,follow',
                ],
            );
        }
    }
}
