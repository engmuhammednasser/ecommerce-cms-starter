<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductVariantController extends Controller
{
    public function create(Product $product): View
    {
        $attributes = ProductAttribute::with('values')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        return view('admin.product-variants.create', [
            'product' => $product,
            'attributes' => $attributes,
            'mediaOptions' => \App\Models\Media::query()->where('mime_type', 'like', 'image/%')->orderBy('original_name')->pluck('original_name', 'id')->all(),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('product_variants', 'sku')],
            'price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', Rule::in(array_keys(ProductVariant::STATUSES))],
            'sort_order' => ['nullable', 'integer'],
            'attribute_value_ids' => ['nullable', 'array'],
            'attribute_value_ids.*' => ['integer', 'exists:attribute_values,id'],
            'image_id' => ['nullable', 'integer', Rule::exists('media', 'id')],
        ]);

        $attributeValueIds = $validated['attribute_value_ids'] ?? [];
        unset($validated['attribute_value_ids']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $variant = $product->variants()->create($validated);
        $variant->attributeValues()->sync($attributeValueIds);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Variant added successfully.');
    }

    public function edit(Product $product, ProductVariant $variant): View
    {
        $variant->load('attributeValues.attribute');

        $attributes = ProductAttribute::with('values')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        $selectedValueIds = $variant->attributeValues->pluck('id')->all();

        return view('admin.product-variants.edit', [
            'product' => $product,
            'variant' => $variant,
            'attributes' => $attributes,
            'selectedValueIds' => $selectedValueIds,
            'mediaOptions' => \App\Models\Media::query()->where('mime_type', 'like', 'image/%')->orderBy('original_name')->pluck('original_name', 'id')->all(),
        ]);
    }

    public function update(Request $request, Product $product, ProductVariant $variant): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => ['nullable', 'string', 'max:255', Rule::unique('product_variants', 'sku')->ignore($variant->id)],
            'price' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', Rule::in(array_keys(ProductVariant::STATUSES))],
            'sort_order' => ['nullable', 'integer'],
            'attribute_value_ids' => ['nullable', 'array'],
            'attribute_value_ids.*' => ['integer', 'exists:attribute_values,id'],
            'image_id' => ['nullable', 'integer', Rule::exists('media', 'id')],
        ]);

        $attributeValueIds = $validated['attribute_value_ids'] ?? [];
        unset($validated['attribute_value_ids']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $variant->update($validated);
        $variant->attributeValues()->sync($attributeValueIds);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Variant updated successfully.');
    }

    public function destroy(Product $product, ProductVariant $variant): RedirectResponse
    {
        $variant->delete();

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'Variant deleted.');
    }
}
