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
                'value' => $category->name,
                'required' => true,
            ])

            @include('admin.components.form.input', [
                'name' => 'slug',
                'label' => 'Slug',
                'value' => $category->slug,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'description',
                'label' => 'Description',
                'value' => $category->description,
                'rows' => 8,
            ])

            @include('admin.components.form.media-picker-input', [
                'name' => 'image',
                'label' => 'Image Path',
                'value' => $category->image,
            ])
        </div>

        <div class="col-lg-4">
            @include('admin.components.form.select', [
                'name' => 'parent_id',
                'label' => 'Parent Category',
                'selected' => $category->parent_id,
                'placeholder' => 'No parent',
                'options' => $parentOptions,
            ])

            @include('admin.components.form.select', [
                'name' => 'status',
                'label' => 'Status',
                'selected' => $category->status ?: 'draft',
                'required' => true,
                'placeholder' => 'Choose status',
                'options' => \App\Models\Category::STATUSES,
            ])

            @include('admin.components.form.input', [
                'name' => 'sort_order',
                'label' => 'Sort Order',
                'value' => $category->sort_order ?? 0,
                'type' => 'number',
                'required' => true,
            ])

            @include('admin.components.form.input', [
                'name' => 'seo_title',
                'label' => 'SEO Title',
                'value' => $category->seo_title,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'seo_description',
                'label' => 'SEO Description',
                'value' => $category->seo_description,
                'rows' => 3,
            ])

            @include('admin.components.form.media-picker-input', [
                'name' => 'seo_image',
                'label' => 'SEO Image',
                'value' => $category->seo_image,
            ])

            {{-- Visual Image IDs (TASK-055A) --}}
            <div class="card card-outline card-secondary mt-3">
                <div class="card-header"><h6 class="card-title mb-0">Visual Images (Media Library)</h6></div>
                <div class="card-body">
                    @include('admin.components.form.media-select', [
                        'name' => 'cover_image_id',
                        'label' => 'Cover Image',
                        'selected' => $category->cover_image_id,
                        'mediaOptions' => $mediaOptions,
                    ])
                    @include('admin.components.form.media-select', [
                        'name' => 'icon_image_id',
                        'label' => 'Icon Image',
                        'selected' => $category->icon_image_id,
                        'mediaOptions' => $mediaOptions,
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Category</button>
    </div>
</form>
