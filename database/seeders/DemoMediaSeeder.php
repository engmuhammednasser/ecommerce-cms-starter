<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Media;
use App\Models\PageSection;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/**
 * TASK-055C — Idempotent demo media seeder.
 * Registers local SVG demo assets as Media records, then assigns
 * main_image_id / hover_image_id / cover_image_id / desktop_image_id etc.
 * to the demo products, categories, and page sections.
 *
 * Safe to run multiple times. Does NOT truncate any table.
 */
class DemoMediaSeeder extends Seeder
{
    /**
     * All demo asset definitions.
     * key => path relative to storage/app/public  (used in Media.path)
     *
     * @var array<string, array{path: string, name: string, alt: string, mime: string}>
     */
    private array $assets = [
        'logo'                   => ['path' => 'demo/logo.svg',                   'name' => 'logo.svg',                   'alt' => 'Store logo',                     'mime' => 'image/svg+xml'],
        'favicon'                => ['path' => 'demo/favicon.svg',                'name' => 'favicon.svg',                'alt' => 'Store favicon',                  'mime' => 'image/svg+xml'],
        'hero'                   => ['path' => 'demo/hero.svg',                   'name' => 'hero.svg',                   'alt' => 'Storefront hero',                'mime' => 'image/svg+xml'],
        'hero_desktop'           => ['path' => 'demo/hero-desktop.svg',           'name' => 'hero-desktop.svg',           'alt' => 'Hero — desktop',                 'mime' => 'image/svg+xml'],
        'hero_mobile'            => ['path' => 'demo/hero-mobile.svg',            'name' => 'hero-mobile.svg',            'alt' => 'Hero — mobile',                  'mime' => 'image/svg+xml'],
        'banner'                 => ['path' => 'demo/banner.svg',                 'name' => 'banner.svg',                 'alt' => 'Promotional banner',             'mime' => 'image/svg+xml'],
        'banner_bg'              => ['path' => 'demo/banner-bg.svg',              'name' => 'banner-bg.svg',              'alt' => 'Banner background',              'mime' => 'image/svg+xml'],
        'category_fashion'       => ['path' => 'demo/category-fashion.svg',       'name' => 'category-fashion.svg',       'alt' => 'Fashion category',               'mime' => 'image/svg+xml'],
        'category_home'          => ['path' => 'demo/category-home.svg',          'name' => 'category-home.svg',          'alt' => 'Home & Living category',         'mime' => 'image/svg+xml'],
        'product_backpack'       => ['path' => 'demo/product-backpack.svg',       'name' => 'product-backpack.svg',       'alt' => 'City Backpack',                  'mime' => 'image/svg+xml'],
        'product_backpack_hover' => ['path' => 'demo/product-backpack-hover.svg', 'name' => 'product-backpack-hover.svg', 'alt' => 'City Backpack — alternate view', 'mime' => 'image/svg+xml'],
        'product_lamp'           => ['path' => 'demo/product-lamp.svg',           'name' => 'product-lamp.svg',           'alt' => 'Desk Lamp',                      'mime' => 'image/svg+xml'],
        'product_lamp_hover'     => ['path' => 'demo/product-lamp-hover.svg',     'name' => 'product-lamp-hover.svg',     'alt' => 'Desk Lamp — alternate view',     'mime' => 'image/svg+xml'],
        'product_sneakers'       => ['path' => 'demo/product-sneakers.svg',       'name' => 'product-sneakers.svg',       'alt' => 'Everyday Sneakers',              'mime' => 'image/svg+xml'],
        'product_sneakers_hover' => ['path' => 'demo/product-sneakers-hover.svg', 'name' => 'product-sneakers-hover.svg', 'alt' => 'Everyday Sneakers — alternate', 'mime' => 'image/svg+xml'],
    ];

    public function run(): void
    {
        // 1. Register all demo media records (idempotent by path).
        /** @var array<string, Media> $media */
        $media = [];

        foreach ($this->assets as $key => $asset) {
            $sizeBytes = $this->fileSize($asset['path']);

            $media[$key] = Media::updateOrCreate(
                ['path' => $asset['path']],
                [
                    'disk'          => 'public',
                    'original_name' => $asset['name'],
                    'file_name'     => $asset['name'],
                    'mime_type'     => $asset['mime'],
                    'size'          => $sizeBytes,
                    'type'          => 'image',
                    'alt_text'      => $asset['alt'],
                ]
            );
        }

        // 2. Assign images to products (by name, sets only if column is null).
        $this->assignProduct('City Backpack',     $media, 'product_backpack',       'product_backpack_hover',   'product_backpack');
        $this->assignProduct('Desk Lamp',         $media, 'product_lamp',           'product_lamp_hover',       'product_lamp');
        $this->assignProduct('Everyday Sneakers', $media, 'product_sneakers',       'product_sneakers_hover',   'product_sneakers');

        // 3. Assign images to categories.
        $this->assignCategory('Fashion', $media, 'category_fashion', 'category_fashion');
        $this->assignCategory('Home',    $media, 'category_home',    'category_home');

        // 4. Assign images to homepage page sections.
        $this->assignSection('hero',   $media,
            desktop: 'hero_desktop', mobile: 'hero_mobile', bg: null,
            alt: 'Shop the latest collection', position: 'center', overlay: 'dark');

        $this->assignSection('banner', $media,
            desktop: 'banner_bg', mobile: null, bg: 'banner_bg',
            alt: 'Summer Sale promotional banner', position: 'center', overlay: 'dark');

        // 5. Seed default storefront image settings (idempotent).
        $defaults = [
            ['group' => 'store', 'key' => 'default_product_image',  'value' => 'demo/product-backpack.svg'],
            ['group' => 'store', 'key' => 'default_category_image', 'value' => 'demo/category-fashion.svg'],
            ['group' => 'store', 'key' => 'default_hero_image',     'value' => 'demo/hero-desktop.svg'],
            ['group' => 'store', 'key' => 'default_og_image',       'value' => 'demo/hero.svg'],
        ];

        foreach ($defaults as $s) {
            Setting::updateOrCreate(
                ['group' => $s['group'], 'key' => $s['key']],
                ['value' => $s['value'], 'type' => 'image']
            );
        }
    }

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    /** @param array<string, Media> $media */
    private function assignProduct(string $name, array $media, string $mainKey, string $hoverKey, string $seoKey): void
    {
        $product = Product::where('name', $name)->first();
        if (! $product) {
            return;
        }

        $product->main_image_id  = $product->main_image_id  ?? ($media[$mainKey]->id  ?? null);
        $product->hover_image_id = $product->hover_image_id ?? ($media[$hoverKey]->id ?? null);
        $product->seo_image_id   = $product->seo_image_id   ?? ($media[$seoKey]->id   ?? null);
        $product->save();
    }

    /** @param array<string, Media> $media */
    private function assignCategory(string $name, array $media, string $coverKey, string $iconKey): void
    {
        $category = Category::where('name', $name)->first();
        if (! $category) {
            return;
        }

        $category->cover_image_id = $category->cover_image_id ?? ($media[$coverKey]->id ?? null);
        $category->icon_image_id  = $category->icon_image_id  ?? ($media[$iconKey]->id  ?? null);
        $category->save();
    }

    /** @param array<string, Media> $media */
    private function assignSection(
        string $type,
        array $media,
        ?string $desktop,
        ?string $mobile,
        ?string $bg,
        ?string $alt,
        ?string $position,
        ?string $overlay
    ): void {
        $section = PageSection::where('type', $type)->first();
        if (! $section) {
            return;
        }

        if ($desktop && isset($media[$desktop]) && ! $section->desktop_image_id) {
            $section->desktop_image_id = $media[$desktop]->id;
        }
        if ($mobile && isset($media[$mobile]) && ! $section->mobile_image_id) {
            $section->mobile_image_id = $media[$mobile]->id;
        }
        if ($bg && isset($media[$bg]) && ! $section->background_image_id) {
            $section->background_image_id = $media[$bg]->id;
        }
        if ($alt && ! $section->image_alt) {
            $section->image_alt = $alt;
        }
        if ($position && ! $section->image_position) {
            $section->image_position = $position;
        }
        if ($overlay && ! $section->overlay_style) {
            $section->overlay_style = $overlay;
        }

        $section->save();
    }

    private function fileSize(string $relativePath): int
    {
        $full = storage_path('app/public/' . $relativePath);
        return file_exists($full) ? (int) filesize($full) : 0;
    }
}
