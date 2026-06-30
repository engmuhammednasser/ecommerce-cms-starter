<dl class="row mb-0">
    <dt class="col-sm-3">Name</dt>
    <dd class="col-sm-9">{{ $category->name }}</dd>

    <dt class="col-sm-3">Slug</dt>
    <dd class="col-sm-9">{{ $category->slug }}</dd>

    <dt class="col-sm-3">Parent</dt>
    <dd class="col-sm-9">{{ $category->parent?->name ?: 'None' }}</dd>

    <dt class="col-sm-3">Image</dt>
    <dd class="col-sm-9">{{ $category->image ?: 'Not set' }}</dd>

    <dt class="col-sm-3">Description</dt>
    <dd class="col-sm-9">{!! nl2br(e($category->description ?: '')) !!}</dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">@include('admin.components.status-badge', ['status' => $category->status])</dd>

    <dt class="col-sm-3">Sort Order</dt>
    <dd class="col-sm-9">{{ $category->sort_order }}</dd>

    <dt class="col-sm-3">Child Categories</dt>
    <dd class="col-sm-9">{{ $category->children->count() }}</dd>

    <dt class="col-sm-3">SEO Title</dt>
    <dd class="col-sm-9">{{ $category->seo_title ?: 'Not set' }}</dd>

    <dt class="col-sm-3">SEO Description</dt>
    <dd class="col-sm-9">{{ $category->seo_description ?: 'Not set' }}</dd>

    <dt class="col-sm-3">SEO Image</dt>
    <dd class="col-sm-9">{{ $category->seo_image ?: 'Not set' }}</dd>
</dl>
