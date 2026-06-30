<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $home = Page::query()->where('slug', 'home')->first();

        $sections = [
            [
                'type' => 'hero',
                'title' => 'Editable Storefront Hero',
                'subtitle' => 'Built from page sections and media records.',
                'content' => 'Use the admin homepage sections module to change this demo content.',
                'image' => 'demo/hero.svg',
                'button_text' => 'Browse Products',
                'button_url' => '/shop',
                'sort_order' => 10,
            ],
            [
                'type' => 'banner',
                'title' => 'Seasonal Demo Banner',
                'subtitle' => 'Replace this banner from the dashboard.',
                'content' => 'Demo media is stored locally and registered in the media library.',
                'image' => 'demo/banner.svg',
                'button_text' => 'View Categories',
                'button_url' => '/shop',
                'sort_order' => 20,
            ],
            [
                'type' => 'categories_grid',
                'title' => 'Featured Categories',
                'subtitle' => 'Category data is managed from the catalog.',
                'content' => 'This section is ready for the frontend renderer task.',
                'image' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 30,
            ],
            [
                'type' => 'featured_products',
                'title' => 'Featured Products',
                'subtitle' => 'Products are seeded as editable catalog records.',
                'content' => 'Browse highlighted products from the catalog.',
                'image' => null,
                'button_text' => 'Shop All',
                'button_url' => '/shop',
                'sort_order' => 40,
            ],
            [
                'type' => 'cta',
                'title' => 'Editable Demo Offer',
                'subtitle' => 'Offer section',
                'content' => 'Change this call to action from the homepage sections module.',
                'image' => null,
                'button_text' => 'View Products',
                'button_url' => '/shop',
                'sort_order' => 45,
            ],
            [
                'type' => 'testimonials',
                'title' => 'Customer Feedback',
                'subtitle' => 'Demo customer',
                'content' => 'This testimonial is seeded as editable section content.',
                'image' => null,
                'button_text' => null,
                'button_url' => null,
                'sort_order' => 48,
            ],
            [
                'type' => 'newsletter',
                'title' => 'Newsletter Signup',
                'subtitle' => 'Email features are implemented in a later task.',
                'content' => 'Use this editable section to introduce a future newsletter form.',
                'image' => null,
                'button_text' => 'Contact Us',
                'button_url' => '/contact',
                'sort_order' => 50,
            ],
        ];

        foreach ($sections as $section) {
            PageSection::query()->updateOrCreate(
                ['page_id' => $home?->id, 'type' => $section['type'], 'sort_order' => $section['sort_order']],
                $section + [
                    'page_id' => $home?->id,
                    'settings' => [],
                    'is_active' => true,
                ],
            );
        }
    }
}
