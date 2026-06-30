<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $fashion = Category::query()->where('slug', 'fashion')->first();
        $home = Category::query()->where('slug', 'home')->first();

        $products = [
            [
                'category_id' => $fashion?->id,
                'name' => 'City Backpack',
                'slug' => 'city-backpack',
                'short_description' => 'A practical demo backpack with replaceable media.',
                'description' => 'This product is seeded as editable catalog data for the starter kit demo.',
                'price' => 79.00,
                'sale_price' => 59.00,
                'sku' => 'DEMO-BACKPACK',
                'stock_quantity' => 25,
                'featured' => true,
                'image' => 'demo/product-backpack.svg',
            ],
            [
                'category_id' => $home?->id,
                'name' => 'Desk Lamp',
                'slug' => 'desk-lamp',
                'short_description' => 'A warm demo lamp for home collections.',
                'description' => 'This editable demo product is connected to the existing products module.',
                'price' => 45.00,
                'sale_price' => null,
                'sku' => 'DEMO-LAMP',
                'stock_quantity' => 18,
                'featured' => true,
                'image' => 'demo/product-lamp.svg',
            ],
            [
                'category_id' => $fashion?->id,
                'name' => 'Everyday Sneakers',
                'slug' => 'everyday-sneakers',
                'short_description' => 'Comfortable demo sneakers for storefront browsing.',
                'description' => 'Use the admin dashboard to edit this product, price, inventory, and SEO.',
                'price' => 99.00,
                'sale_price' => 89.00,
                'sku' => 'DEMO-SNEAKERS',
                'stock_quantity' => 32,
                'featured' => false,
                'image' => 'demo/product-sneakers.svg',
            ],
        ];

        foreach ($products as $productData) {
            $image = $productData['image'];
            unset($productData['image']);

            $product = Product::query()->updateOrCreate(
                ['slug' => $productData['slug']],
                $productData + [
                    'status' => 'published',
                    'seo_title' => $productData['name'],
                    'seo_description' => $productData['short_description'],
                    'seo_image' => $image,
                ],
            );

            $media = Media::query()->where('path', $image)->first();

            $product->images()->updateOrCreate(
                ['path' => $image],
                [
                    'media_id' => $media?->id,
                    'alt_text' => $product->name,
                    'sort_order' => 0,
                    'is_primary' => true,
                ],
            );
        }
    }
}
