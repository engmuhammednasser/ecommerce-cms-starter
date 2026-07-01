<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function index(Request $request): View
    {
        $coupons = Coupon::query()
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create(): View
    {
        return view('admin.coupons.create', [
            'coupon' => new Coupon([
                'discount_type' => 'fixed',
                'status' => 'active',
                'minimum_order_amount' => 0,
                'discount_value' => 0,
            ]),
        ]);
    }

    public function store(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $coupon = Coupon::query()->create($this->validatedData($request));
        $activityLogger->log('coupon_created', $coupon);

        return redirect()
            ->route('admin.coupons.show', $coupon)
            ->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon): View
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon): View
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon, ActivityLogger $activityLogger): RedirectResponse
    {
        $coupon->update($this->validatedData($request, $coupon));
        $activityLogger->log('coupon_updated', $coupon);

        return redirect()
            ->route('admin.coupons.show', $coupon)
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon, ActivityLogger $activityLogger): RedirectResponse
    {
        $activityLogger->log('coupon_deleted', $coupon);
        $coupon->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Coupon $coupon = null): array
    {
        $request->merge([
            'code' => Str::upper(trim((string) $request->input('code'))),
        ]);

        return $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($coupon?->id)],
            'name' => ['nullable', 'string', 'max:255'],
            'discount_type' => ['required', 'string', Rule::in(array_keys(Coupon::DISCOUNT_TYPES))],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'minimum_order_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'status' => ['required', 'string', Rule::in(array_keys(Coupon::STATUSES))],
        ]);
    }
}
