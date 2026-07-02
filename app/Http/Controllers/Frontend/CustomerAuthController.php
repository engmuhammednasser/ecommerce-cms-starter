<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class CustomerAuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('frontend.themes.default.customer.login', $this->themeData([
            'title' => 'Customer Login',
        ]));
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm(): View
    {
        return view('frontend.themes.default.customer.register', $this->themeData([
            'title' => 'Customer Registration',
        ]));
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => 'active',
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
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
