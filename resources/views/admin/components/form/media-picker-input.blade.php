@php
    $type = $type ?? 'text';
    $name = $name ?? '';
    $id = $id ?? str_replace(['[', ']', '.'], ['_', '', '_'], $name);
    $label = $label ?? ucfirst(str_replace('_', ' ', $name));
    $value = old($name, $value ?? '');
    $required = $required ?? false;
    $help = $help ?? 'Select an existing image from the media library.';
@endphp

<div class="mb-3" data-media-picker-field>
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <input
        id="{{ $id }}"
        type="hidden"
        name="{{ $name }}"
        value="{{ $value }}"
        class="@error($name) is-invalid @enderror"
        data-media-picker-preview="{{ $id }}_preview"
        @required($required)
    >

    <div id="{{ $id }}_preview" class="admin-media-picker-preview mb-2" data-media-picker-preview-box>
        @if ($value)
            <img src="{{ asset('storage/' . $value) }}" alt="{{ $label }}" class="img-thumbnail admin-media-picker-image">
        @else
            <div class="admin-media-picker-empty text-center text-muted border rounded p-4">
                <div class="fw-semibold text-body">No image selected</div>
                <div class="small">Choose an image from the media library.</div>
            </div>
        @endif
    </div>

    <div class="d-flex flex-wrap gap-2">
        <button
            type="button"
            class="btn btn-outline-secondary"
            data-media-picker-open
            data-media-picker-target="{{ $id }}"
        >
            {{ $value ? 'Update Image' : 'Choose Image' }}
        </button>
        <button
            type="button"
            class="btn btn-outline-danger {{ $value ? '' : 'd-none' }}"
            data-media-picker-remove
            data-media-picker-target="{{ $id }}"
        >
            Remove Image
        </button>
    </div>
    <div class="form-text">{{ $help }}</div>
    @error($name)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
