{{-- Attribute value selection --}}
<div class="mb-3">
    <label class="form-label fw-semibold">Attribute Values</label>
    <div class="border rounded p-3" style="max-height: 280px; overflow-y: auto;">
        @forelse ($attributes as $attribute)
            <div class="mb-2">
                <div class="fw-semibold text-muted small mb-1">{{ $attribute->name }}</div>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($attribute->values as $value)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox"
                                name="attribute_value_ids[]"
                                value="{{ $value->id }}"
                                id="av_{{ $value->id }}"
                                {{ in_array($value->id, $selectedValueIds ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="av_{{ $value->id }}">{{ $value->value }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-muted small mb-0">No active attributes found. <a href="{{ route('admin.attributes.create') }}">Create one first</a>.</p>
        @endforelse
    </div>
    @error('attribute_value_ids')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>

@include('admin.components.form.input', [
    'name' => 'sku',
    'label' => 'Variant SKU (optional)',
    'value' => old('sku', $variant->sku ?? ''),
])

<div class="row">
    <div class="col-md-6">
        @include('admin.components.form.input', [
            'name' => 'price',
            'label' => 'Price (leave blank to use product price)',
            'value' => old('price', $variant->price ?? ''),
            'type' => 'number',
        ])
    </div>
    <div class="col-md-6">
        @include('admin.components.form.input', [
            'name' => 'sale_price',
            'label' => 'Sale Price (optional)',
            'value' => old('sale_price', $variant->sale_price ?? ''),
            'type' => 'number',
        ])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        @include('admin.components.form.input', [
            'name' => 'stock_quantity',
            'label' => 'Stock Quantity',
            'value' => old('stock_quantity', $variant->stock_quantity ?? 0),
            'type' => 'number',
            'required' => true,
        ])
    </div>
    <div class="col-md-6">
        @include('admin.components.form.input', [
            'name' => 'sort_order',
            'label' => 'Sort Order',
            'value' => old('sort_order', $variant->sort_order ?? 0),
            'type' => 'number',
        ])
    </div>
</div>

@include('admin.components.form.select', [
    'name' => 'status',
    'label' => 'Status',
    'selected' => old('status', $variant->status ?? 'active'),
    'required' => true,
    'options' => \App\Models\ProductVariant::STATUSES,
])

{{-- Visual Image (TASK-055A) --}}
@include('admin.components.form.media-select', [
    'name' => 'image_id',
    'label' => 'Variant Image (Media Library)',
    'selected' => old('image_id', $variant->image_id ?? null),
    'mediaOptions' => $mediaOptions,
])
