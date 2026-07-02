<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.form.select', [
                'name' => 'type',
                'label' => 'Section Type',
                'selected' => $section->type,
                'required' => true,
                'placeholder' => 'Choose section type',
                'options' => \App\Models\PageSection::TYPES,
            ])

            @include('admin.components.form.input', [
                'name' => 'title',
                'label' => 'Title',
                'value' => $section->title,
            ])

            @include('admin.components.form.input', [
                'name' => 'subtitle',
                'label' => 'Subtitle',
                'value' => $section->subtitle,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'content',
                'label' => 'Content',
                'value' => $section->content,
                'rows' => 6,
            ])

            @include('admin.components.form.textarea', [
                'name' => 'settings',
                'label' => 'Settings JSON',
                'value' => old('settings', $section->settings ? json_encode($section->settings, JSON_PRETTY_PRINT) : ''),
                'rows' => 6,
            ])
        </div>

        <div class="col-lg-4">
            @include('admin.components.form.select', [
                'name' => 'page_id',
                'label' => 'Related Page',
                'selected' => $section->page_id,
                'placeholder' => 'Homepage / global section',
                'options' => $pages,
            ])

            @include('admin.components.form.input', [
                'name' => 'sort_order',
                'label' => 'Sort Order',
                'value' => $section->sort_order ?? 0,
                'type' => 'number',
                'required' => true,
            ])

            <div class="form-check mb-3">
                <input type="hidden" name="is_active" value="0">
                <input id="is_active" type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $section->is_active ?? true))>
                <label for="is_active" class="form-check-label">Active</label>
            </div>

            @include('admin.components.form.media-picker-input', [
                'name' => 'image',
                'label' => 'Image Path',
                'value' => $section->image,
            ])

            @include('admin.components.form.input', [
                'name' => 'button_text',
                'label' => 'Button Text',
                'value' => $section->button_text,
            ])

            @include('admin.components.form.input', [
                'name' => 'button_url',
                'label' => 'Button URL',
                'value' => $section->button_url,
            ])

            {{-- Visual Image IDs (TASK-055A) --}}
            <div class="card card-outline card-secondary mt-3">
                <div class="card-header"><h6 class="card-title mb-0">Visual Images (Media Library)</h6></div>
                <div class="card-body">
                    @include('admin.components.form.media-select', [
                        'name' => 'desktop_image_id',
                        'label' => 'Desktop Image',
                        'selected' => $section->desktop_image_id,
                        'mediaOptions' => $mediaOptions,
                    ])
                    @include('admin.components.form.media-select', [
                        'name' => 'mobile_image_id',
                        'label' => 'Mobile Image',
                        'selected' => $section->mobile_image_id,
                        'mediaOptions' => $mediaOptions,
                    ])
                    @include('admin.components.form.media-select', [
                        'name' => 'background_image_id',
                        'label' => 'Background Image',
                        'selected' => $section->background_image_id,
                        'mediaOptions' => $mediaOptions,
                    ])
                    @include('admin.components.form.input', [
                        'name' => 'image_alt',
                        'label' => 'Image Alt Text',
                        'value' => $section->image_alt,
                    ])
                    @include('admin.components.form.select', [
                        'name' => 'image_position',
                        'label' => 'Image Position',
                        'selected' => $section->image_position,
                        'placeholder' => '— Default —',
                        'options' => ['left' => 'Left', 'right' => 'Right', 'center' => 'Center', 'top' => 'Top', 'bottom' => 'Bottom'],
                    ])
                    @include('admin.components.form.select', [
                        'name' => 'overlay_style',
                        'label' => 'Overlay Style',
                        'selected' => $section->overlay_style,
                        'placeholder' => '— None —',
                        'options' => ['dark' => 'Dark', 'light' => 'Light', 'gradient' => 'Gradient', 'none' => 'None'],
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.sections.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Section</button>
    </div>
</form>
