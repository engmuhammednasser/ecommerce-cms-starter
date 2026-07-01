<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.form.input', [
                'name' => 'name',
                'label' => 'Name',
                'value' => $product->name,
                'required' => true,
            ])

            @include('admin.components.form.input', [
                'name' => 'slug',
                'label' => 'Slug',
                'value' => $product->slug,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'short_description',
                'label' => 'Short Description',
                'value' => $product->short_description,
                'rows' => 4,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'description',
                'label' => 'Full Description',
                'value' => $product->description,
                'rows' => 10,
            ])

            @include('admin.components.form.product-images-picker', [
                'name' => 'image_paths',
                'label' => 'Product Images',
                'value' => $imagePaths,
            ])
        </div>

        <div class="col-lg-4">
            @include('admin.components.form.select', [
                'name' => 'category_id',
                'label' => 'Category',
                'selected' => $product->category_id,
                'placeholder' => 'No category',
                'options' => $categoryOptions,
            ])

            @include('admin.components.form.select', [
                'name' => 'brand_id',
                'label' => 'Brand',
                'selected' => $product->brand_id,
                'placeholder' => 'No brand',
                'options' => $brandOptions,
            ])

            @include('admin.components.form.select', [
                'name' => 'status',
                'label' => 'Status',
                'selected' => $product->status ?: 'draft',
                'required' => true,
                'placeholder' => 'Choose status',
                'options' => \App\Models\Product::STATUSES,
            ])

            @include('admin.components.form.input', [
                'name' => 'price',
                'label' => 'Price',
                'value' => $product->price ?? 0,
                'type' => 'number',
                'required' => true,
            ])

            @include('admin.components.form.input', [
                'name' => 'sale_price',
                'label' => 'Sale Price',
                'value' => $product->sale_price,
                'type' => 'number',
            ])

            @include('admin.components.form.input', [
                'name' => 'sku',
                'label' => 'SKU',
                'value' => $product->sku,
            ])

            @include('admin.components.form.input', [
                'name' => 'stock_quantity',
                'label' => 'Stock Quantity',
                'value' => $product->stock_quantity ?? 0,
                'type' => 'number',
                'required' => true,
            ])

            <div class="form-check mb-3">
                <input type="hidden" name="featured" value="0">
                <input id="featured" type="checkbox" name="featured" value="1" class="form-check-input" @checked(old('featured', $product->featured))>
                <label for="featured" class="form-check-label">Featured Product</label>
            </div>

            @include('admin.components.form.input', [
                'name' => 'seo_title',
                'label' => 'SEO Title',
                'value' => $product->seo_title,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'seo_description',
                'label' => 'SEO Description',
                'value' => $product->seo_description,
                'rows' => 3,
            ])

            @include('admin.components.form.media-picker-input', [
                'name' => 'seo_image',
                'label' => 'SEO Image',
                'value' => $product->seo_image,
            ])
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Product</button>
    </div>
</form>
