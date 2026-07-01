<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * @var array<int, array{group: string, key: string, value: string|null, type: string}>
     */
    private array $foundationSettings = [
        ['group' => 'general', 'key' => 'site_name', 'value' => 'Demo Store', 'type' => 'text'],
        ['group' => 'general', 'key' => 'logo', 'value' => 'demo/logo.svg', 'type' => 'image'],
        ['group' => 'general', 'key' => 'favicon', 'value' => 'demo/favicon.svg', 'type' => 'image'],
        ['group' => 'admin', 'key' => 'login_title', 'value' => 'Welcome back', 'type' => 'text'],
        ['group' => 'admin', 'key' => 'login_subtitle', 'value' => 'Sign in to manage your store.', 'type' => 'textarea'],
        ['group' => 'admin', 'key' => 'login_button_label', 'value' => 'Sign in', 'type' => 'text'],
        ['group' => 'admin', 'key' => 'login_image', 'value' => 'demo/hero.svg', 'type' => 'image'],
        ['group' => 'payment', 'key' => 'cash_on_delivery_enabled', 'value' => '1', 'type' => 'boolean'],
        ['group' => 'shipping', 'key' => 'flat_rate', 'value' => '0', 'type' => 'number'],
        ['group' => 'shipping', 'key' => 'free_shipping_threshold', 'value' => null, 'type' => 'number'],
        ['group' => 'tax', 'key' => 'percentage', 'value' => '0', 'type' => 'number'],
    ];

    public function index(): View
    {
        $this->ensureFoundationSettings();

        $settings = Setting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['nullable', 'array'],
            'settings.*' => ['nullable', 'string', 'max:2000'],
        ]);

        $values = $validated['settings'] ?? [];

        Setting::query()
            ->get()
            ->each(function (Setting $setting) use ($values): void {
                $fullKey = $setting->fullKey();

                if (array_key_exists($fullKey, $values)) {
                    $setting->update(['value' => $values[$fullKey]]);
                }
            });

        $activityLogger->log('settings_updated');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    private function ensureFoundationSettings(): void
    {
        foreach ($this->foundationSettings as $setting) {
            Setting::query()->firstOrCreate(
                ['group' => $setting['group'], 'key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']],
            );
        }
    }
}
