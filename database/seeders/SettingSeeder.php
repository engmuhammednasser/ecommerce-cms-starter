<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * @var array<int, array{group: string, key: string, value: string|null, type: string}>
     */
    private array $settings = [
        ['group' => 'general', 'key' => 'site_name', 'value' => 'Demo Store', 'type' => 'text'],
        ['group' => 'general', 'key' => 'logo', 'value' => 'demo/logo.svg', 'type' => 'image'],
        ['group' => 'general', 'key' => 'favicon', 'value' => 'demo/favicon.svg', 'type' => 'image'],
        ['group' => 'theme', 'key' => 'primary_color', 'value' => '#0d6efd', 'type' => 'color'],
        ['group' => 'theme', 'key' => 'secondary_color', 'value' => '#6c757d', 'type' => 'color'],
        ['group' => 'contact', 'key' => 'email', 'value' => 'hello@example.com', 'type' => 'email'],
        ['group' => 'contact', 'key' => 'phone', 'value' => '+1 555 0100', 'type' => 'text'],
        ['group' => 'contact', 'key' => 'whatsapp', 'value' => '+1 555 0100', 'type' => 'text'],
        ['group' => 'contact', 'key' => 'address', 'value' => 'Demo Store Address', 'type' => 'textarea'],
        ['group' => 'social', 'key' => 'facebook', 'value' => '#', 'type' => 'url'],
        ['group' => 'social', 'key' => 'instagram', 'value' => '#', 'type' => 'url'],
        ['group' => 'social', 'key' => 'tiktok', 'value' => '#', 'type' => 'url'],
        ['group' => 'social', 'key' => 'youtube', 'value' => '#', 'type' => 'url'],
        ['group' => 'seo', 'key' => 'default_title', 'value' => 'Demo Store', 'type' => 'text'],
        ['group' => 'seo', 'key' => 'default_description', 'value' => 'A reusable Laravel e-commerce CMS starter kit.', 'type' => 'textarea'],
        ['group' => 'seo', 'key' => 'default_image', 'value' => 'demo/hero.svg', 'type' => 'image'],
        ['group' => 'seo', 'key' => 'default_sharing_image', 'value' => 'demo/hero.svg', 'type' => 'image'],
        ['group' => 'analytics', 'key' => 'google_analytics_id', 'value' => null, 'type' => 'text'],
        ['group' => 'analytics', 'key' => 'facebook_pixel_id', 'value' => null, 'type' => 'text'],
        ['group' => 'payment', 'key' => 'cash_on_delivery_enabled', 'value' => '1', 'type' => 'boolean'],
        ['group' => 'shipping', 'key' => 'flat_rate', 'value' => '0', 'type' => 'number'],
        ['group' => 'shipping', 'key' => 'free_shipping_threshold', 'value' => null, 'type' => 'number'],
        ['group' => 'tax', 'key' => 'percentage', 'value' => '0', 'type' => 'number'],
    ];

    public function run(): void
    {
        foreach ($this->settings as $setting) {
            Setting::updateOrCreate(
                ['group' => $setting['group'], 'key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']],
            );
        }
    }
}
