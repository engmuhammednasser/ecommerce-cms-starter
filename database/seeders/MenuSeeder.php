<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $home = Page::query()->where('slug', 'home')->first();
        $about = Page::query()->where('slug', 'about')->first();
        $contact = Page::query()->where('slug', 'contact')->first();
        $privacy = Page::query()->where('slug', 'privacy-policy')->first();
        $fashion = Category::query()->where('slug', 'fashion')->first();

        $header = Menu::query()->updateOrCreate(
            ['slug' => 'header-menu'],
            ['name' => 'Header Menu', 'location' => 'header'],
        );

        $footer = Menu::query()->updateOrCreate(
            ['slug' => 'footer-menu'],
            ['name' => 'Footer Menu', 'location' => 'footer'],
        );

        $mobile = Menu::query()->updateOrCreate(
            ['slug' => 'mobile-menu'],
            ['name' => 'Mobile Menu', 'location' => 'mobile'],
        );

        $this->syncItems($header, [
            ['label' => 'Home', 'type' => 'page', 'reference_id' => $home?->id, 'url' => '/', 'sort_order' => 10],
            ['label' => 'Shop', 'type' => 'custom', 'reference_id' => null, 'url' => '/shop', 'sort_order' => 20],
            ['label' => 'Fashion', 'type' => 'category', 'reference_id' => $fashion?->id, 'url' => $fashion ? '/categories/'.$fashion->slug : '/shop', 'sort_order' => 30],
            ['label' => 'About', 'type' => 'page', 'reference_id' => $about?->id, 'url' => '/about', 'sort_order' => 40],
            ['label' => 'Contact', 'type' => 'page', 'reference_id' => $contact?->id, 'url' => '/contact', 'sort_order' => 50],
        ]);

        $this->syncItems($footer, [
            ['label' => 'Shop', 'type' => 'custom', 'reference_id' => null, 'url' => '/shop', 'sort_order' => 10],
            ['label' => 'About', 'type' => 'page', 'reference_id' => $about?->id, 'url' => '/about', 'sort_order' => 20],
            ['label' => 'Privacy Policy', 'type' => 'page', 'reference_id' => $privacy?->id, 'url' => '/privacy-policy', 'sort_order' => 30],
        ]);

        $this->syncItems($mobile, [
            ['label' => 'Home', 'type' => 'page', 'reference_id' => $home?->id, 'url' => '/', 'sort_order' => 10],
            ['label' => 'Shop', 'type' => 'custom', 'reference_id' => null, 'url' => '/shop', 'sort_order' => 20],
            ['label' => 'Cart', 'type' => 'custom', 'reference_id' => null, 'url' => '/cart', 'sort_order' => 30],
        ]);
    }

    /**
     * @param array<int, array<string, mixed>> $items
     */
    private function syncItems(Menu $menu, array $items): void
    {
        foreach ($items as $item) {
            $menu->items()->updateOrCreate(
                ['label' => $item['label'], 'sort_order' => $item['sort_order']],
                $item + [
                    'parent_id' => null,
                    'is_active' => true,
                ],
            );
        }
    }
}
