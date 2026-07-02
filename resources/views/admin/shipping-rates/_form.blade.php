@include('admin.components.form.input', [
    'name' => 'name',
    'label' => 'Rate Name (e.g. Standard, Express)',
    'value' => old('name', $shippingRate->name ?? ''),
    'required' => true,
])

@include('admin.components.form.input', [
    'name' => 'rate',
    'label' => 'Cost Rate',
    'type' => 'number',
    'step' => '0.01',
    'value' => old('rate', $shippingRate->rate ?? 0),
    'required' => true,
])

@include('admin.components.form.input', [
    'name' => 'free_shipping_threshold',
    'label' => 'Free Shipping Threshold (optional)',
    'type' => 'number',
    'step' => '0.01',
    'value' => old('free_shipping_threshold', $shippingRate->free_shipping_threshold ?? ''),
    'help' => 'Leave blank if free shipping does not apply to this rate.',
])

@include('admin.components.form.input', [
    'name' => 'sort_order',
    'label' => 'Sort Order',
    'type' => 'number',
    'value' => old('sort_order', $shippingRate->sort_order ?? 0),
])

<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $shippingRate->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
</div>
