<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use App\Support\SeoMeta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function shop(Request $request): View
    {
        $products = $this->productQuery()
            ->when($request->filled('category'), function ($query) use ($request): void {
                $query->whereHas('category', function ($query) use ($request): void {
                    $query->where('slug', $request->string('category')->toString());
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('frontend.themes.default.shop', $this->themeData(array_merge(SeoMeta::defaults(setting('catalog.shop_title', 'Shop')), [
            'title' => setting('catalog.shop_title', 'Shop'),
            'products' => $products,
            'categories' => $this->publishedCategories(),
        ])));
    }

    public function category(Category $category): View
    {
        abort_unless($category->status === 'published', 404);

        $products = $this->productQuery()
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('frontend.themes.default.category', $this->themeData(array_merge(SeoMeta::forCategory($category), [
            'title' => $category->name,
            'category' => $category,
            'products' => $products,
            'categories' => $this->publishedCategories(),
        ])));
    }

    public function product(Product $product): View
    {
        abort_unless($product->status === 'published', 404);

        $product->load('category', 'images');

        return view('frontend.themes.default.product-details', $this->themeData(array_merge(SeoMeta::forProduct($product), [
            'title' => $product->name,
            'product' => $product,
        ])));
    }

    private function productQuery()
    {
        return Product::query()
            ->with('category', 'primaryImage')
            ->where('status', 'published');
    }

    private function publishedCategories()
    {
        return Category::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function themeData(array $data): array
    {
        $headerMenu = Menu::query()
            ->where('location', 'header')
            ->with(['items' => fn ($query) => $query->where('is_active', true)])
            ->first();

        $footerMenu = Menu::query()
            ->where('location', 'footer')
            ->with(['items' => fn ($query) => $query->where('is_active', true)])
            ->first();

        return array_merge([
            'storeName' => setting('general.site_name', config('app.name', 'Laravel')),
            'footerText' => setting('general.site_name', config('app.name', 'Laravel')),
            'headerMenuItems' => $headerMenu?->items ?? collect(),
            'footerMenuItems' => $footerMenu?->items ?? collect(),
        ], $data);
    }
}
