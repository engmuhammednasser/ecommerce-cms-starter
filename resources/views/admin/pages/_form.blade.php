<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.form.input', [
                'name' => 'title',
                'label' => 'Title',
                'value' => $page->title,
                'required' => true,
            ])

            @include('admin.components.form.input', [
                'name' => 'slug',
                'label' => 'Slug',
                'value' => $page->slug,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'content',
                'label' => 'Content',
                'value' => $page->content,
                'rows' => 12,
            ])
        </div>

        <div class="col-lg-4">
            @include('admin.components.form.select', [
                'name' => 'status',
                'label' => 'Status',
                'selected' => $page->status ?: 'draft',
                'required' => true,
                'placeholder' => 'Choose status',
                'options' => [
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ],
            ])

            @include('admin.components.form.input', [
                'name' => 'seo_title',
                'label' => 'SEO Title',
                'value' => $page->seo_title,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'seo_description',
                'label' => 'SEO Description',
                'value' => $page->seo_description,
                'rows' => 3,
            ])

            @include('admin.components.form.media-picker-input', [
                'name' => 'seo_image',
                'label' => 'SEO Image',
                'value' => $page->seo_image,
            ])

            @include('admin.components.form.input', [
                'name' => 'canonical_url',
                'label' => 'Canonical URL',
                'value' => $page->canonical_url,
                'type' => 'url',
            ])

            @include('admin.components.form.input', [
                'name' => 'meta_robots',
                'label' => 'Meta Robots',
                'value' => $page->meta_robots,
            ])
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Page</button>
    </div>
</form>
