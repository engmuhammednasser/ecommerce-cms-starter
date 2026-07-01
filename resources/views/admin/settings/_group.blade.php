<div class="row g-3">
    @foreach ($items as $setting)
        @php
            $name = 'settings[' . $setting->fullKey() . ']';
            $labels = [
                'site_name' => 'Store Name',
                'logo' => 'Store Logo',
                'favicon' => 'Favicon',
                'login_title' => 'Login Title',
                'login_subtitle' => 'Login Subtitle',
                'login_button_label' => 'Login Button Text',
                'login_image' => 'Login Side Image',
                'primary_color' => 'Primary Color',
                'secondary_color' => 'Secondary Color',
                'announcement_text' => 'Announcement Text',
                'show_cart_link' => 'Show Cart Link',
                'cart_label' => 'Cart Label',
                'show_store_name' => 'Show Store Name',
                'text' => 'Footer Text',
                'cash_on_delivery_enabled' => 'Enable Cash on Delivery',
                'flat_rate' => 'Flat Shipping Rate',
                'free_shipping_threshold' => 'Free Shipping Threshold',
                'percentage' => 'Tax Percentage',
            ];
            $label = $labels[$setting->key] ?? ucfirst(str_replace('_', ' ', $setting->key));
            $id = str_replace('.', '_', $setting->fullKey());
            $type = match ($setting->type) {
                'email' => 'email',
                'url' => 'text',
                'color' => 'color',
                'number' => 'number',
                default => 'text',
            };
            $columnClass = in_array($setting->type, ['textarea', 'image'], true) ? 'col-12' : 'col-md-6';
        @endphp

        <div class="{{ $columnClass }}">
            @if ($setting->type === 'boolean')
                <input type="hidden" name="{{ $name }}" value="0">
                <div class="settings-toggle border rounded p-3 h-100">
                    <div class="form-check form-switch mb-0">
                        <input
                            id="{{ $id }}"
                            type="checkbox"
                            name="{{ $name }}"
                            value="1"
                            class="form-check-input"
                            @checked(old($name, $setting->value) === '1')
                        >
                        <label for="{{ $id }}" class="form-check-label fw-semibold">{{ $label }}</label>
                    </div>
                </div>
            @elseif ($setting->type === 'textarea')
                @include('admin.components.form.textarea', [
                    'name' => $name,
                    'id' => $id,
                    'label' => $label,
                    'value' => $setting->value,
                    'rows' => 4,
                ])
            @elseif ($setting->type === 'image')
                @include('admin.components.form.media-picker-input', [
                    'name' => $name,
                    'id' => $id,
                    'label' => $label,
                    'value' => $setting->value,
                    'type' => 'text',
                ])
            @else
                @include('admin.components.form.input', [
                    'name' => $name,
                    'id' => $id,
                    'label' => $label,
                    'value' => $setting->value,
                    'type' => $type,
                ])
            @endif
        </div>
    @endforeach
</div>
