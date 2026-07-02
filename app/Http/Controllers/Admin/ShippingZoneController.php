<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingZoneController extends Controller
{
    public function index(): View
    {
        $zones = ShippingZone::with('rates')->orderBy('sort_order')->get();
        return view('admin.shipping-zones.index', compact('zones'));
    }

    public function create(): View
    {
        return view('admin.shipping-zones.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        ShippingZone::create($validated);

        return redirect()->route('admin.shipping-zones.index')->with('success', 'Shipping zone created.');
    }

    public function edit(ShippingZone $shippingZone): View
    {
        $shippingZone->load('rates');
        return view('admin.shipping-zones.edit', compact('shippingZone'));
    }

    public function update(Request $request, ShippingZone $shippingZone): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $shippingZone->update($validated);

        return redirect()->route('admin.shipping-zones.index')->with('success', 'Shipping zone updated.');
    }

    public function destroy(ShippingZone $shippingZone): RedirectResponse
    {
        $shippingZone->delete();
        return redirect()->route('admin.shipping-zones.index')->with('success', 'Shipping zone deleted.');
    }
}
