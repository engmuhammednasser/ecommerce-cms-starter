<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.form.input', ['name' => 'name', 'label' => 'Name', 'value' => $attribute->name, 'required' => true])
            @include('admin.components.form.input', ['name' => 'slug', 'label' => 'Slug', 'value' => $attribute->slug])
            @include('admin.components.form.textarea', [
                'name' => 'values',
                'label' => 'Values',
                'value' => $valuesText,
                'rows' => 8,
                'help' => 'Add one value per line, for example Small, Medium, Large.',
            ])
        </div>

        <div class="col-lg-4">
            @include('admin.components.form.select', [
                'name' => 'type',
                'label' => 'Type',
                'selected' => $attribute->type ?: 'select',
                'required' => true,
                'options' => \App\Models\ProductAttribute::TYPES,
            ])
            @include('admin.components.form.select', [
                'name' => 'status',
                'label' => 'Status',
                'selected' => $attribute->status ?: 'active',
                'required' => true,
                'options' => \App\Models\ProductAttribute::STATUSES,
            ])
            @include('admin.components.form.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'value' => $attribute->sort_order ?? 0, 'type' => 'number', 'required' => true])
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.attributes.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Attribute</button>
    </div>
</form>
