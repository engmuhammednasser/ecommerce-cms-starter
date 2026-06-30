@php
    $type = $type ?? 'text';
    $name = $name ?? '';
    $id = $id ?? $name;
    $label = $label ?? ucfirst(str_replace('_', ' ', $name));
    $value = old($name, $value ?? '');
    $required = $required ?? false;
@endphp

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input
        id="{{ $id }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        class="form-control @error($name) is-invalid @enderror"
        @required($required)
    >
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
