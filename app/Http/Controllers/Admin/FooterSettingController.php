<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FooterSettingController extends Controller
{
    /**
     * @var array<int, array{group: string, key: string, value: string|null, type: string}>
     */
    private array $footerSettings = [
        ['group' => 'footer', 'key' => 'text', 'value' => null, 'type' => 'textarea'],
        ['group' => 'footer', 'key' => 'show_store_name', 'value' => '1', 'type' => 'boolean'],
    ];

    public function index(): View
    {
        $this->ensureFooterSettings();

        $items = Setting::query()
            ->where('group', 'footer')
            ->orderBy('key')
            ->get();

        return view('admin.footer-settings.index', compact('items'));
    }

    public function update(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $validated = $request->validate([
            'settings' => ['nullable', 'array'],
            'settings.*' => ['nullable', 'string', 'max:2000'],
        ]);

        $values = $validated['settings'] ?? [];

        Setting::query()
            ->where('group', 'footer')
            ->get()
            ->each(function (Setting $setting) use ($values): void {
                $fullKey = $setting->fullKey();

                if (array_key_exists($fullKey, $values)) {
                    $setting->update(['value' => $values[$fullKey]]);
                }
            });

        $activityLogger->log('footer_settings_updated');

        return redirect()
            ->route('admin.footer-settings.index')
            ->with('success', 'Footer settings updated successfully.');
    }

    private function ensureFooterSettings(): void
    {
        foreach ($this->footerSettings as $setting) {
            Setting::query()->firstOrCreate(
                ['group' => $setting['group'], 'key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']],
            );
        }
    }
}
