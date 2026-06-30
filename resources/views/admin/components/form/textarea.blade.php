@php
    $name = $name ?? '';
    $id = $id ?? $name;
    $label = $label ?? ucfirst(str_replace('_', ' ', $name));
    $value = old($name, $value ?? '');
    $rows = $rows ?? 4;
    $required = $required ?? false;
@endphp

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        class="form-control @error($name) is-invalid @enderror"
        @required($required)
    >{{ $value }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
