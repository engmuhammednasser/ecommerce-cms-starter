<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        static $settings = null;

        if ($settings === null) {
            try {
                if (! Schema::hasTable('settings')) {
                    return $default;
                }

                $settings = Setting::query()
                    ->get()
                    ->mapWithKeys(fn (Setting $setting): array => [$setting->fullKey() => $setting->value]);
            } catch (Throwable) {
                return $default;
            }
        }

        return $settings->get($key, $default);
    }
}
