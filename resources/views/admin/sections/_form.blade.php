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
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.sections.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Section</button>
    </div>
</form>
