<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use App\Support\SeoMeta;
use Illuminate\Database\Eloquent\Builder;
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
            });

        $products = $this->applyFilters($products, $request)
            ->paginate(12)
            ->withQueryString();

        return view('frontend.themes.default.shop', $this->themeData(array_merge(SeoMeta::defaults(setting('catalog.shop_title', 'Shop')), [
            'title' => setting('catalog.shop_title', 'Shop'),
            'products' => $products,
            'categories' => $this->publishedTopLevelCategories(),
        ])));
    }

    public function category(Request $request, Category $category): View
    {
        abort_unless($category->status === 'published', 404);

        $products = $this->productQuery()
            ->where('category_id', $category->id);

        $products = $this->applyFilters($products, $request)
            ->paginate(12)
            ->withQueryString();

        return view('frontend.themes.default.category', $this->themeData(array_merge(SeoMeta::forCategory($category), [
            'title' => $category->name,
            'category' => $category,
            'products' => $products,
            'categories' => $this->publishedTopLevelCategories(),
        ])));
    }

    public function product(Product $product): View
    {
        abort_unless($product->status === 'published', 404);

        $product->load('category', 'images', 'mainImage', 'hoverImage', 'variants.attributeValues.attribute');

        $activeVariants = $product->variants->where('status', 'active')->values();

        return view('frontend.themes.default.product-details', $this->themeData(array_merge(SeoMeta::forProduct($product), [
            'title' => $product->name,
            'product' => $product,
            'variants' => $activeVariants,
        ])));
    }

    private function productQuery(): Builder
    {
        return Product::query()
            ->with('category', 'primaryImage', 'mainImage', 'hoverImage')
            ->where('status', 'published');
    }

    private function publishedTopLevelCategories()
    {
        return Category::query()
            ->where('status', 'published')
            ->whereNull('parent_id')
            ->with(['coverImage', 'children' => function ($q) {
                $q->where('status', 'published')->with('coverImage')->orderBy('sort_order')->orderBy('name');
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    private function applyFilters(Builder $query, Request $request): Builder
    {
        // Search
        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Price Min
        if ($request->filled('min_price')) {
            $minPrice = (float) $request->input('min_price');
            $query->whereRaw('COALESCE(sale_price, price) >= ?', [$minPrice]);
        }

        // Price Max
        if ($request->filled('max_price')) {
            $maxPrice = (float) $request->input('max_price');
            $query->whereRaw('COALESCE(sale_price, price) <= ?', [$maxPrice]);
        }

        // In Stock
        if ($request->boolean('in_stock')) {
            $query->where('stock_quantity', '>', 0);
        }

        // On Sale
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('sale_price')->where('sale_price', '>', 0);
        }

        // Sorting
        $sort = $request->string('sort', 'latest')->toString();
        switch ($sort) {
            case 'price_asc':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        return $query;
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
