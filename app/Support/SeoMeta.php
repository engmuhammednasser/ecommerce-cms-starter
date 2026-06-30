<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Support\Str;

class SeoMeta
{
    /**
     * @return array<string, string|null>
     */
    public static function defaults(?string $title = null): array
    {
        $defaultTitle = setting('seo.default_title', setting('general.site_name', config('app.name', 'Laravel')));
        $defaultDescription = setting('seo.default_description');

        return [
            'metaTitle' => self::clean($title) ?: self::clean($defaultTitle) ?: config('app.name', 'Laravel'),
            'metaDescription' => self::clean($defaultDescription),
            'metaImage' => self::imageUrl(setting('seo.default_sharing_image', setting('seo.default_image'))),
            'canonicalUrl' => url()->current(),
            'metaRobots' => 'index, follow',
        ];
    }

    /**
     * @return array<string, string|null>
     */
    public static function forPage(?Page $page, ?string $fallbackTitle = null): array
    {
        $defaults = self::defaults($fallbackTitle ?: $page?->title);

        if (! $page) {
            return $defaults;
        }

        return array_merge($defaults, [
            'metaTitle' => self::clean($page->seo_title) ?: $defaults['metaTitle'],
            'metaDescription' => self::clean($page->seo_description) ?: $defaults['metaDescription'],
            'metaImage' => self::imageUrl($page->seo_image) ?: $defaults['metaImage'],
            'canonicalUrl' => self::clean($page->canonical_url) ?: $defaults['canonicalUrl'],
            'metaRobots' => self::clean($page->meta_robots) ?: $defaults['metaRobots'],
        ]);
    }

    /**
     * @return array<string, string|null>
     */
    public static function forProduct(Product $product): array
    {
        $defaults = self::defaults($product->name);

        return array_merge($defaults, [
            'metaTitle' => self::clean($product->seo_title) ?: $product->name,
            'metaDescription' => self::clean($product->seo_description) ?: self::clean($product->short_description) ?: $defaults['metaDescription'],
            'metaImage' => self::imageUrl($product->seo_image) ?: $defaults['metaImage'],
            'canonicalUrl' => route('catalog.products.show', $product),
        ]);
    }

    /**
     * @return array<string, string|null>
     */
    public static function forCategory(Category $category): array
    {
        $defaults = self::defaults($category->name);

        return array_merge($defaults, [
            'metaTitle' => self::clean($category->seo_title) ?: $category->name,
            'metaDescription' => self::clean($category->seo_description) ?: self::clean($category->description) ?: $defaults['metaDescription'],
            'metaImage' => self::imageUrl($category->seo_image ?: $category->image) ?: $defaults['metaImage'],
            'canonicalUrl' => route('catalog.categories.show', $category),
        ]);
    }

    private static function clean(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim(strip_tags($value));

        return $value === '' ? null : Str::limit($value, 300, '');
    }

    private static function imageUrl(mixed $path): ?string
    {
        $path = self::clean($path);

        if (! $path) {
            return null;
        }

        return Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/'.$path);
    }
}
