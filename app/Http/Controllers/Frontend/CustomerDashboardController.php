<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    public function index(): View
    {
        $customer = Auth::guard('customer')->user();
        $recentOrders = $customer->orders()->latest()->take(5)->get();

        return view('frontend.themes.default.customer.dashboard', $this->themeData([
            'title' => 'My Account',
            'customer' => $customer,
            'recentOrders' => $recentOrders,
        ]));
    }

    public function orders(): View
    {
        $customer = Auth::guard('customer')->user();
        $orders = $customer->orders()->with('items')->latest()->paginate(10);

        return view('frontend.themes.default.customer.orders', $this->themeData([
            'title' => 'Order History',
            'orders' => $orders,
        ]));
    }

    public function addresses(): View
    {
        $customer = Auth::guard('customer')->user();
        $addresses = $customer->addresses()->latest()->get();

        return view('frontend.themes.default.customer.addresses', $this->themeData([
            'title' => 'Saved Addresses',
            'addresses' => $addresses,
        ]));
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $customer = Auth::guard('customer')->user();

        if ($request->boolean('is_default')) {
            $customer->addresses()->update(['is_default' => false]);
        }

        $customer->addresses()->create([
            'label' => $validated['label'] ?? null,
            'address' => $validated['address'],
            'is_default' => $request->boolean('is_default'),
        ]);

        return redirect()->route('customer.addresses')->with('success', 'Address added successfully.');
    }

    public function destroyAddress(CustomerAddress $address): RedirectResponse
    {
        abort_unless($address->customer_id === Auth::guard('customer')->id(), 403);

        $address->delete();

        return redirect()->route('customer.addresses')->with('success', 'Address deleted.');
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function themeData(array $data): array
    {
        $headerMenu = Menu::query()
            ->where('location', 'header')
            ->with(['items' => fn ($query) => $query->where('is_active', true)])
            ->first();

        $footerMenu = Menu::query()
            ->where('location', 'footer')
            ->with(['items' => fn ($query) => $query->where('is_active', true)])
            ->first();

        return array_merge([
            'storeName' => setting('general.site_name', config('app.name', 'Laravel')),
            'footerText' => setting('general.site_name', config('app.name', 'Laravel')),
            'headerMenuItems' => $headerMenu?->items ?? collect(),
            'footerMenuItems' => $footerMenu?->items ?? collect(),
            'metaTitle' => setting('general.site_name', config('app.name', 'Laravel')),
        ], $data);
    }
}
