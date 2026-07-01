<form method="GET" action="{{ route('admin.products.index') }}">
    <div class="row align-items-end">
        <div class="col-lg-4">
            @include('admin.components.form.input', [
                'name' => 'search',
                'label' => 'Search',
                'value' => request('search'),
            ])
        </div>
        <div class="col-lg-2">
            @include('admin.components.form.select', [
                'name' => 'category_id',
                'label' => 'Category',
                'selected' => request('category_id'),
                'placeholder' => 'All categories',
                'options' => $categoryOptions,
            ])
        </div>
        <div class="col-lg-2">
            @include('admin.components.form.select', [
                'name' => 'brand_id',
                'label' => 'Brand',
                'selected' => request('brand_id'),
                'placeholder' => 'All brands',
                'options' => $brandOptions,
            ])
        </div>
        <div class="col-lg-2">
            @include('admin.components.form.select', [
                'name' => 'status',
                'label' => 'Status',
                'selected' => request('status'),
                'placeholder' => 'All statuses',
                'options' => \App\Models\Product::STATUSES,
            ])
        </div>
        <div class="col-lg-1">
            @include('admin.components.form.select', [
                'name' => 'featured',
                'label' => 'Featured',
                'selected' => request('featured'),
                'placeholder' => 'Any',
                'options' => [
                    '1' => 'Featured',
                    '0' => 'Not Featured',
                ],
            ])
        </div>
        <div class="col-lg-1 mb-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>
