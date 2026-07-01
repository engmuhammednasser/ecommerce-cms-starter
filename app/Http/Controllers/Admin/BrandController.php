<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(Request $request): View
    {
        $brands = Brand::query()
            ->withCount('products')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status')->toString());
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('admin.brands.create', [
            'brand' => new Brand(['status' => 'draft', 'sort_order' => 0]),
        ]);
    }

    public function store(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $brand = Brand::query()->create($this->validatedData($request));
        $activityLogger->log('brand_created', $brand);

        return redirect()
            ->route('admin.brands.show', $brand)
            ->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand): View
    {
        $brand->loadCount('products');

        return view('admin.brands.show', compact('brand'));
    }

    public function edit(Brand $brand): View
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand, ActivityLogger $activityLogger): RedirectResponse
    {
        $brand->update($this->validatedData($request, $brand));
        $activityLogger->log('brand_updated', $brand);

        return redirect()
            ->route('admin.brands.show', $brand)
            ->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand, ActivityLogger $activityLogger): RedirectResponse
    {
        $activityLogger->log('brand_deleted', $brand);
        $brand->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Brand $brand = null): array
    {
        $slug = Str::slug((string) ($request->input('slug') ?: $request->input('name')));
        $request->merge(['slug' => $slug]);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('brands', 'slug')->ignore($brand?->id)],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(array_keys(Brand::STATUSES))],
            'sort_order' => ['required', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_image' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
