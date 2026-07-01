<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.form.input', ['name' => 'name', 'label' => 'Name', 'value' => $brand->name, 'required' => true])
            @include('admin.components.form.input', ['name' => 'slug', 'label' => 'Slug', 'value' => $brand->slug])
            @include('admin.components.form.textarea', ['name' => 'description', 'label' => 'Description', 'value' => $brand->description, 'rows' => 8])
            @include('admin.components.form.media-picker-input', ['name' => 'image', 'label' => 'Brand Image', 'value' => $brand->image])
        </div>

        <div class="col-lg-4">
            @include('admin.components.form.select', [
                'name' => 'status',
                'label' => 'Status',
                'selected' => $brand->status ?: 'draft',
                'required' => true,
                'options' => \App\Models\Brand::STATUSES,
            ])
            @include('admin.components.form.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'value' => $brand->sort_order ?? 0, 'type' => 'number', 'required' => true])
            @include('admin.components.form.input', ['name' => 'seo_title', 'label' => 'SEO Title', 'value' => $brand->seo_title])
            @include('admin.components.form.textarea', ['name' => 'seo_description', 'label' => 'SEO Description', 'value' => $brand->seo_description, 'rows' => 3])
            @include('admin.components.form.media-picker-input', ['name' => 'seo_image', 'label' => 'SEO Image', 'value' => $brand->seo_image])
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Brand</button>
    </div>
</form>
