<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use App\Models\ShippingZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingRateController extends Controller
{
    public function create(ShippingZone $shippingZone): View
    {
        return view('admin.shipping-rates.create', compact('shippingZone'));
    }

    public function store(Request $request, ShippingZone $shippingZone): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0'],
            'free_shipping_threshold' => ['nullable', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $shippingZone->rates()->create($validated);

        return redirect()->route('admin.shipping-zones.edit', $shippingZone)->with('success', 'Shipping rate added.');
    }

    public function edit(ShippingZone $shippingZone, ShippingRate $shippingRate): View
    {
        return view('admin.shipping-rates.edit', compact('shippingZone', 'shippingRate'));
    }

    public function update(Request $request, ShippingZone $shippingZone, ShippingRate $shippingRate): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'rate' => ['required', 'numeric', 'min:0'],
            'free_shipping_threshold' => ['nullable', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $shippingRate->update($validated);

        return redirect()->route('admin.shipping-zones.edit', $shippingZone)->with('success', 'Shipping rate updated.');
    }

    public function destroy(ShippingZone $shippingZone, ShippingRate $shippingRate): RedirectResponse
    {
        $shippingRate->delete();
        return redirect()->route('admin.shipping-zones.edit', $shippingZone)->with('success', 'Shipping rate deleted.');
    }
}
