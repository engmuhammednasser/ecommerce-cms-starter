<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with('brand', 'category')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status')->toString());
            })
            ->when($request->filled('category_id'), function ($query) use ($request): void {
                $query->where('category_id', $request->integer('category_id'));
            })
            ->when($request->filled('brand_id'), function ($query) use ($request): void {
                $query->where('brand_id', $request->integer('brand_id'));
            })
            ->when($request->filled('featured'), function ($query) use ($request): void {
                $query->where('featured', $request->boolean('featured'));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'brandOptions' => $this->brandOptions(),
            'categoryOptions' => $this->categoryOptions(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'product' => new Product([
                'price' => 0,
                'stock_quantity' => 0,
                'status' => 'draft',
                'featured' => false,
            ]),
            'brandOptions' => $this->brandOptions(),
            'categoryOptions' => $this->categoryOptions(),
            'mediaOptions' => \App\Models\Media::query()->where('mime_type', 'like', 'image/%')->orderBy('original_name')->pluck('original_name', 'id')->all(),
            'imagePaths' => '',
        ]);
    }

    public function store(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        [$data, $imagePaths] = $this->validatedData($request);
        $product = Product::create($data);
        $this->syncImages($product, $imagePaths);
        $activityLogger->log('product_created', $product);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load('brand', 'category', 'images');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load('images', 'variants.attributeValues.attribute');

        return view('admin.products.edit', [
            'product' => $product,
            'brandOptions' => $this->brandOptions(),
            'categoryOptions' => $this->categoryOptions(),
            'mediaOptions' => \App\Models\Media::query()->where('mime_type', 'like', 'image/%')->orderBy('original_name')->pluck('original_name', 'id')->all(),
            'imagePaths' => $product->images->pluck('path')->implode(PHP_EOL),
        ]);
    }

    public function update(Request $request, Product $product, ActivityLogger $activityLogger): RedirectResponse
    {
        $oldStatus = $product->status;
        [$data, $imagePaths] = $this->validatedData($request, $product);
        $product->update($data);
        $this->syncImages($product, $imagePaths);
        $activityLogger->log('product_updated', $product, [
            'status' => [$oldStatus, $product->status],
        ]);

        return redirect()
            ->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product, ActivityLogger $activityLogger): RedirectResponse
    {
        $activityLogger->log('product_deleted', $product);
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * @return array{0: array<string, mixed>, 1: string}
     */
    private function validatedData(Request $request, ?Product $product = null): array
    {
        $slug = Str::slug((string) ($request->input('slug') ?: $request->input('name')));
        $request->merge(['slug' => $slug]);

        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product?->id)],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product?->id)],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', Rule::in(array_keys(Product::STATUSES))],
            'featured' => ['nullable', 'boolean'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_image' => ['nullable', 'string', 'max:255'],
            'main_image_id' => ['nullable', 'integer', Rule::exists('media', 'id')],
            'hover_image_id' => ['nullable', 'integer', Rule::exists('media', 'id')],
            'seo_image_id' => ['nullable', 'integer', Rule::exists('media', 'id')],
            'image_paths' => ['nullable', 'string'],
        ]);

        $imagePaths = (string) ($validated['image_paths'] ?? '');
        unset($validated['image_paths']);

        $validated['featured'] = $request->boolean('featured');

        return [$validated, $imagePaths];
    }

    private function syncImages(Product $product, string $imagePaths): void
    {
        $paths = collect(preg_split('/\r\n|\r|\n/', $imagePaths) ?: [])
            ->map(fn (string $path): string => trim($path))
            ->filter()
            ->unique()
            ->values();

        $product->images()->delete();

        $paths->each(function (string $path, int $index) use ($product): void {
            $product->images()->create([
                'path' => $path,
                'sort_order' => $index,
                'is_primary' => $index === 0,
            ]);
        });
    }

    /**
     * @return array<int|string, string>
     */
    private function categoryOptions(): array
    {
        return Category::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }

    /**
     * @return array<int|string, string>
     */
    private function brandOptions(): array
    {
        return Brand::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }
}
