<form method="POST" action="{{ route('admin.menus.items.store', $menu) }}">
    @csrf

    <div class="row">
        <div class="col-md-4">
            @include('admin.components.form.input', [
                'name' => 'label',
                'label' => 'Label',
                'value' => '',
                'required' => true,
            ])
        </div>
        <div class="col-md-4">
            @include('admin.components.form.select', [
                'name' => 'type',
                'label' => 'Type',
                'selected' => 'custom',
                'required' => true,
                'placeholder' => 'Choose type',
                'options' => \App\Models\MenuItem::TYPES,
            ])
        </div>
        <div class="col-md-4">
            @include('admin.components.form.select', [
                'name' => 'parent_id',
                'label' => 'Parent Item',
                'selected' => null,
                'placeholder' => 'No parent',
                'options' => $parentItems,
            ])
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            @include('admin.components.form.input', [
                'name' => 'reference_id',
                'label' => 'Reference ID',
                'value' => '',
                'type' => 'number',
            ])
        </div>
        <div class="col-md-4">
            @include('admin.components.form.input', [
                'name' => 'url',
                'label' => 'Custom URL',
                'value' => '',
            ])
        </div>
        <div class="col-md-4">
            @include('admin.components.form.input', [
                'name' => 'sort_order',
                'label' => 'Sort Order',
                'value' => 0,
                'type' => 'number',
                'required' => true,
            ])
        </div>
    </div>

    <div class="form-check mb-3">
        <input type="hidden" name="is_active" value="0">
        <input id="is_active" type="checkbox" name="is_active" value="1" class="form-check-input" checked>
        <label for="is_active" class="form-check-label">Active</label>
    </div>

    <button type="submit" class="btn btn-primary">Add Menu Item</button>
</form>
