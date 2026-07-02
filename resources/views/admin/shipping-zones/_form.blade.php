@include('admin.components.form.input', [
    'name' => 'name',
    'label' => 'Zone Name',
    'value' => old('name', $shippingZone->name ?? ''),
    'required' => true,
])

@include('admin.components.form.input', [
    'name' => 'sort_order',
    'label' => 'Sort Order',
    'type' => 'number',
    'value' => old('sort_order', $shippingZone->sort_order ?? 0),
])

<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $shippingZone->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
</div>
