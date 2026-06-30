@php
    $type = $type ?? 'text';
    $name = $name ?? '';
    $id = $id ?? str_replace(['[', ']', '.'], ['_', '', '_'], $name);
    $label = $label ?? ucfirst(str_replace('_', ' ', $name));
    $value = old($name, $value ?? '');
    $required = $required ?? false;
    $help = $help ?? 'Select an existing image from the media library or enter a storage path.';
@endphp

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <div class="input-group">
        <input
            id="{{ $id }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ $value }}"
            class="form-control @error($name) is-invalid @enderror"
            data-media-picker-preview="{{ $id }}_preview"
            @required($required)
        >
        <button
            type="button"
            class="btn btn-outline-secondary"
            data-media-picker-open
            data-media-picker-target="{{ $id }}"
        >
            Choose
        </button>
        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-text">{{ $help }}</div>
    <div id="{{ $id }}_preview" class="mt-2">
        @if ($value)
            <img src="{{ asset('storage/' . $value) }}" alt="{{ $label }}" class="img-thumbnail" style="width: 96px; height: 96px; object-fit: cover;">
        @endif
    </div>
</div>
