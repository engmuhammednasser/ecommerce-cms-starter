<dl class="row mb-0">
    <dt class="col-sm-3">Title</dt>
    <dd class="col-sm-9">{{ $page->title }}</dd>

    <dt class="col-sm-3">Slug</dt>
    <dd class="col-sm-9">{{ $page->slug }}</dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">@include('admin.components.status-badge', ['status' => $page->status])</dd>

    <dt class="col-sm-3">Content</dt>
    <dd class="col-sm-9">{!! nl2br(e($page->content ?: '')) !!}</dd>

    <dt class="col-sm-3">SEO Title</dt>
    <dd class="col-sm-9">{{ $page->seo_title ?: 'Not set' }}</dd>

    <dt class="col-sm-3">SEO Description</dt>
    <dd class="col-sm-9">{{ $page->seo_description ?: 'Not set' }}</dd>

    <dt class="col-sm-3">SEO Image</dt>
    <dd class="col-sm-9">{{ $page->seo_image ?: 'Not set' }}</dd>

    <dt class="col-sm-3">Canonical URL</dt>
    <dd class="col-sm-9">{{ $page->canonical_url ?: 'Not set' }}</dd>

    <dt class="col-sm-3">Meta Robots</dt>
    <dd class="col-sm-9">{{ $page->meta_robots ?: 'Not set' }}</dd>
</dl>
