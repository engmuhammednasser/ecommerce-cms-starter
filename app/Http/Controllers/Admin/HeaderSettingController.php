<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeaderSettingController extends Controller
{
    /**
     * @var array<int, array{group: string, key: string, value: string|null, type: string}>
     */
    private array $headerSettings = [
        ['group' => 'header', 'key' => 'announcement_text', 'value' => null, 'type' => 'text'],
        ['group' => 'header', 'key' => 'show_cart_link', 'value' => '1', 'type' => 'boolean'],
        ['group' => 'header', 'key' => 'cart_label', 'value' => 'Cart', 'type' => 'text'],
    ];

    public function index(): View
    {
        $this->ensureHeaderSettings();

        $items = Setting::query()
            ->where('group', 'header')
            ->orderBy('key')
            ->get();

        return view('admin.header-settings.index', compact('items'));
    }

    public function update(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['nullable', 'array'],
            'settings.*' => ['nullable', 'string', 'max:2000'],
        ]);

        $values = $validated['settings'] ?? [];

        Setting::query()
            ->where('group', 'header')
            ->get()
            ->each(function (Setting $setting) use ($values): void {
                $fullKey = $setting->fullKey();

                if (array_key_exists($fullKey, $values)) {
                    $setting->update(['value' => $values[$fullKey]]);
                }
            });

        $activityLogger->log('header_settings_updated');

        return redirect()
            ->route('admin.header-settings.index')
            ->with('success', 'Header settings updated successfully.');
    }

    private function ensureHeaderSettings(): void
    {
        foreach ($this->headerSettings as $setting) {
            Setting::query()->firstOrCreate(
                ['group' => $setting['group'], 'key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']],
            );
        }
    }
}
