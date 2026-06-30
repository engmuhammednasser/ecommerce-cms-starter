<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'image' => 'demo/category-fashion.svg',
                'description' => 'Editable fashion category for demo products.',
                'sort_order' => 10,
            ],
            [
                'name' => 'Home',
                'slug' => 'home',
                'image' => 'demo/category-home.svg',
                'description' => 'Editable home category for demo products.',
                'sort_order' => 20,
            ],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category + [
                    'parent_id' => null,
                    'status' => 'published',
                    'seo_title' => $category['name'].' Products',
                    'seo_description' => $category['description'],
                    'seo_image' => $category['image'],
                ],
            );
        }
    }
}
