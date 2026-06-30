<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Product;
use App\Support\SeoMeta;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $home = Page::query()->where('slug', 'home')->where('status', 'published')->first();

        $sections = PageSection::query()
            ->where('is_active', true)
            ->when($home, fn ($query) => $query->where('page_id', $home->id))
            ->orderBy('sort_order')
            ->get();

        return view('frontend.themes.default.home', $this->themeData(array_merge(SeoMeta::forPage($home), [
            'sections' => $sections,
            'categories' => Category::query()
                ->where('status', 'published')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'featuredProducts' => Product::query()
                ->with('category', 'primaryImage')
                ->where('status', 'published')
                ->where('featured', true)
                ->latest()
                ->take(6)
                ->get(),
        ])));
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
