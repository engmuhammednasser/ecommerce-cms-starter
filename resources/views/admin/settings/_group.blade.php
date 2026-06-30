@foreach ($items as $setting)
    @php
        $name = 'settings[' . $setting->fullKey() . ']';
        $label = ucfirst(str_replace('_', ' ', $setting->key));
        $type = match ($setting->type) {
            'email' => 'email',
            'url' => 'url',
            'color' => 'color',
            'number' => 'number',
            default => 'text',
        };
    @endphp

    @if ($setting->type === 'boolean')
        <input type="hidden" name="{{ $name }}" value="0">
        <div class="form-check mb-3">
            <input
                id="{{ str_replace('.', '_', $setting->fullKey()) }}"
                type="checkbox"
                name="{{ $name }}"
                value="1"
                class="form-check-input"
                @checked(old($name, $setting->value) === '1')
            >
            <label for="{{ str_replace('.', '_', $setting->fullKey()) }}" class="form-check-label">{{ $label }}</label>
        </div>
    @elseif ($setting->type === 'textarea')
        @include('admin.components.form.textarea', [
            'name' => $name,
            'id' => str_replace('.', '_', $setting->fullKey()),
            'label' => $label,
            'value' => $setting->value,
            'rows' => 3,
        ])
    @elseif ($setting->type === 'image')
        @include('admin.components.form.media-picker-input', [
            'name' => $name,
            'id' => str_replace('.', '_', $setting->fullKey()),
            'label' => $label,
            'value' => $setting->value,
            'type' => 'text',
        ])
    @else
        @include('admin.components.form.input', [
            'name' => $name,
            'id' => str_replace('.', '_', $setting->fullKey()),
            'label' => $label,
            'value' => $setting->value,
            'type' => $type,
        ])
    @endif
@endforeach
