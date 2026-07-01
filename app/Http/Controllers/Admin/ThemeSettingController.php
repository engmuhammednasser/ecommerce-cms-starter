<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThemeSettingController extends Controller
{
    /**
     * @var array<int, array{group: string, key: string, value: string|null, type: string}>
     */
    private array $themeSettings = [
        ['group' => 'theme', 'key' => 'primary_color', 'value' => '#0d6efd', 'type' => 'color'],
        ['group' => 'theme', 'key' => 'secondary_color', 'value' => '#6c757d', 'type' => 'color'],
    ];

    public function index(): View
    {
        $this->ensureThemeSettings();

        $items = Setting::query()
            ->where('group', 'theme')
            ->orderBy('key')
            ->get();

        return view('admin.theme-settings.index', compact('items'));
    }

    public function update(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['nullable', 'array'],
            'settings.*' => ['nullable', 'string', 'max:2000'],
        ]);

        $values = $validated['settings'] ?? [];

        Setting::query()
            ->where('group', 'theme')
            ->get()
            ->each(function (Setting $setting) use ($values): void {
                $fullKey = $setting->fullKey();

                if (array_key_exists($fullKey, $values)) {
                    $setting->update(['value' => $values[$fullKey]]);
                }
            });

        $activityLogger->log('theme_settings_updated');

        return redirect()
            ->route('admin.theme-settings.index')
            ->with('success', 'Theme settings updated successfully.');
    }

    private function ensureThemeSettings(): void
    {
        foreach ($this->themeSettings as $setting) {
            Setting::query()->firstOrCreate(
                ['group' => $setting['group'], 'key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']],
            );
        }
    }
}
