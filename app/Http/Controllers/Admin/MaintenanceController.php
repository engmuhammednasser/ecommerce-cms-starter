<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    /**
     * @var array<string, array{label: string, command: string}>
     */
    private array $clearActions = [
        'application' => ['label' => 'Application Cache', 'command' => 'cache:clear'],
        'config' => ['label' => 'Config Cache', 'command' => 'config:clear'],
        'view' => ['label' => 'View Cache', 'command' => 'view:clear'],
        'route' => ['label' => 'Route Cache', 'command' => 'route:clear'],
    ];

    public function index(): View
    {
        $storageLink = public_path('storage');

        return view('admin.maintenance.index', [
            'systemInfo' => [
                'App version' => config('app.version', 'Not configured'),
                'Laravel version' => app()->version(),
                'PHP version' => PHP_VERSION,
                'Environment' => app()->environment(),
                'Debug status' => config('app.debug') ? 'Enabled' : 'Disabled',
                'Database connection' => DB::connection()->getName(),
                'Application cache store' => config('cache.default', 'Not configured'),
                'Config cache' => app()->configurationIsCached() ? 'Cached' : 'Not cached',
                'Route cache' => app()->routesAreCached() ? 'Cached' : 'Not cached',
                'View cache' => $this->viewCacheStatus(),
                'Storage link' => file_exists($storageLink) ? 'Available' : 'Missing',
            ],
            'clearActions' => $this->clearActions,
        ]);
    }

    public function clear(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'target' => ['required', 'string', 'in:'.implode(',', array_keys($this->clearActions))],
        ]);

        $action = $this->clearActions[$validated['target']];

        Artisan::call($action['command']);

        return redirect()
            ->route('admin.maintenance.index')
            ->with('success', $action['label'].' cleared successfully.');
    }

    private function viewCacheStatus(): string
    {
        $files = glob(storage_path('framework/views/*.php')) ?: [];

        return count($files) > 0 ? 'Cached files present' : 'No cached files detected';
    }
}
