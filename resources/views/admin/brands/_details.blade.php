<dl class="row mb-0">
    <dt class="col-sm-3">Name</dt>
    <dd class="col-sm-9">{{ $brand->name }}</dd>

    <dt class="col-sm-3">Slug</dt>
    <dd class="col-sm-9">{{ $brand->slug }}</dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">@include('admin.components.status-badge', ['status' => $brand->status])</dd>

    <dt class="col-sm-3">Products</dt>
    <dd class="col-sm-9">{{ $brand->products_count }}</dd>

    <dt class="col-sm-3">Image</dt>
    <dd class="col-sm-9">
        @if ($brand->image)
            <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" class="img-thumbnail admin-media-picker-image">
        @else
            <span class="text-muted">No image</span>
        @endif
    </dd>

    <dt class="col-sm-3">Description</dt>
    <dd class="col-sm-9">{{ $brand->description ?: 'None' }}</dd>
</dl>
