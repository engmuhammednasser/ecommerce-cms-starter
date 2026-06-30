<dl class="row mb-0">
    <dt class="col-sm-3">Name</dt>
    <dd class="col-sm-9">{{ $product->name }}</dd>

    <dt class="col-sm-3">Slug</dt>
    <dd class="col-sm-9">{{ $product->slug }}</dd>

    <dt class="col-sm-3">Category</dt>
    <dd class="col-sm-9">{{ $product->category?->name ?: 'None' }}</dd>

    <dt class="col-sm-3">SKU</dt>
    <dd class="col-sm-9">{{ $product->sku ?: 'Not set' }}</dd>

    <dt class="col-sm-3">Price</dt>
    <dd class="col-sm-9">{{ number_format((float) $product->price, 2) }}</dd>

    <dt class="col-sm-3">Sale Price</dt>
    <dd class="col-sm-9">{{ $product->sale_price !== null ? number_format((float) $product->sale_price, 2) : 'Not set' }}</dd>

    <dt class="col-sm-3">Stock Quantity</dt>
    <dd class="col-sm-9">{{ $product->stock_quantity }}</dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">@include('admin.components.status-badge', ['status' => $product->status])</dd>

    <dt class="col-sm-3">Featured</dt>
    <dd class="col-sm-9">{{ $product->featured ? 'Yes' : 'No' }}</dd>

    <dt class="col-sm-3">Short Description</dt>
    <dd class="col-sm-9">{!! nl2br(e($product->short_description ?: '')) !!}</dd>

    <dt class="col-sm-3">Full Description</dt>
    <dd class="col-sm-9">{!! nl2br(e($product->description ?: '')) !!}</dd>

    <dt class="col-sm-3">Images</dt>
    <dd class="col-sm-9">
        @forelse ($product->images as $image)
            <div>{{ $image->path }}</div>
        @empty
            Not set
        @endforelse
    </dd>

    <dt class="col-sm-3">SEO Title</dt>
    <dd class="col-sm-9">{{ $product->seo_title ?: 'Not set' }}</dd>

    <dt class="col-sm-3">SEO Description</dt>
    <dd class="col-sm-9">{{ $product->seo_description ?: 'Not set' }}</dd>

    <dt class="col-sm-3">SEO Image</dt>
    <dd class="col-sm-9">{{ $product->seo_image ?: 'Not set' }}</dd>
</dl>
