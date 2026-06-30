@php
    $name = $name ?? '';
    $id = $id ?? $name;
    $label = $label ?? ucfirst(str_replace('_', ' ', $name));
    $options = $options ?? [];
    $selected = old($name, $selected ?? null);
    $placeholder = $placeholder ?? 'Select an option';
    $required = $required ?? false;
@endphp

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <select
        id="{{ $id }}"
        name="{{ $name }}"
        class="form-select @error($name) is-invalid @enderror"
        @required($required)
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" @selected((string) $selected === (string) $value)>{{ $text }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
