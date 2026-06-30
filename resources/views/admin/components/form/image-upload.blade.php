@php
    $name = $name ?? 'image';
    $id = $id ?? $name;
    $label = $label ?? 'Image';
    $help = $help ?? 'Upload image support will connect to the media library in a later task.';
@endphp

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input
        id="{{ $id }}"
        type="file"
        name="{{ $name }}"
        accept="image/*"
        class="form-control @error($name) is-invalid @enderror"
    >
    <div class="form-text">{{ $help }}</div>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
