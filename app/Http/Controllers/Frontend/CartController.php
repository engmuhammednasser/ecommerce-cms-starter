<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Product;
use App\Services\CouponDiscountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CartController extends Controller
{
    public function show(Request $request): View
    {
        return view('frontend.themes.default.cart', $this->themeData([
            'title' => setting('cart.title', 'Cart'),
            'metaTitle' => setting('cart.title', setting('general.site_name', config('app.name', 'Laravel'))),
            'cart' => $this->cartSummary($request),
        ]));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->status === 'published', 404);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
            'variant_id' => ['nullable', 'integer'],
        ]);

        if ($product->hasVariants() && empty($validated['variant_id'])) {
            return back()->with('error', 'Please select a product option.');
        }

        if (!empty($validated['variant_id'])) {
            $variant = $product->variants()->where('id', $validated['variant_id'])->where('status', 'active')->firstOrFail();
        }

        $items = $this->cartItems($request);
        $cartKey = (string) $product->id;
        if (!empty($validated['variant_id'])) {
            $cartKey .= '_' . $validated['variant_id'];
        }

        $items[$cartKey] = ($items[$cartKey] ?? 0) + (int) $validated['quantity'];

        $request->session()->put('cart.items', $items);

        return redirect()
            ->route('cart.show')
            ->with('success', 'Product added to cart.');
    }

    public function update(Request $request, string $cartKey): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $items = $this->cartItems($request);

        if (array_key_exists($cartKey, $items)) {
            $items[$cartKey] = (int) $validated['quantity'];
            $request->session()->put('cart.items', $items);
        }

        return redirect()
            ->route('cart.show')
            ->with('success', 'Cart updated.');
    }

    public function destroy(Request $request, string $cartKey): RedirectResponse
    {
        $items = $this->cartItems($request);
        unset($items[$cartKey]);

        $request->session()->put('cart.items', $items);

        return redirect()
            ->route('cart.show')
            ->with('success', 'Product removed from cart.');
    }

    public function applyCoupon(Request $request, CouponDiscountService $coupons): RedirectResponse
    {
        $validated = $request->validate([
            'coupon_code' => ['required', 'string', 'max:50'],
        ]);

        $cart = $this->cartSummary($request);
        $result = $coupons->validateCode($validated['coupon_code'], $cart['subtotal']);

        if (! $result['valid']) {
            return redirect()
                ->route('cart.show')
                ->with('error', $result['message']);
        }

        $request->session()->put('cart.coupon_code', $result['coupon']?->code);

        return redirect()
            ->route('cart.show')
            ->with('success', 'Coupon applied.');
    }

    public function removeCoupon(Request $request): RedirectResponse
    {
        $request->session()->forget('cart.coupon_code');

        return redirect()
            ->route('cart.show')
            ->with('success', 'Coupon removed.');
    }

    /**
     * @return array<string, int>
     */
    private function cartItems(Request $request): array
    {
        return collect($request->session()->get('cart.items', []))
            ->mapWithKeys(fn ($quantity, $key): array => [(string) $key => max(1, (int) $quantity)])
            ->all();
    }

    /**
     * @return array{items: Collection<int, array<string, mixed>>, subtotal: float, item_count: int, coupon: array<string, mixed>|null, discount: float}
     */
    private function cartSummary(Request $request): array
    {
        $items = $this->cartItems($request);
        $productIds = collect(array_keys($items))->map(fn ($k) => explode('_', $k)[0])->unique()->all();

        $products = Product::query()
            ->with('primaryImage', 'variants.attributeValues.attribute')
            ->where('status', 'published')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $lines = collect($items)
            ->map(function (int $quantity, string $cartKey) use ($products): ?array {
                $parts = explode('_', $cartKey);
                $productId = (int) $parts[0];
                $variantId = isset($parts[1]) ? (int) $parts[1] : null;

                $product = $products->get($productId);

                if (! $product) {
                    return null;
                }

                $variant = null;
                $label = null;
                if ($variantId) {
                    $variant = $product->variants->firstWhere('id', $variantId);
                    if (!$variant || $variant->status !== 'active') return null;
                    $label = $variant->label();
                }

                $unitPrice = $variant ? $variant->effectivePrice($product) : (float) ($product->sale_price ?: $product->price);

                return [
                    'cart_key' => $cartKey,
                    'product' => $product,
                    'variant' => $variant,
                    'variant_label' => $label,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $unitPrice * $quantity,
                ];
            })
            ->filter()
            ->values();

        $coupon = null;
        $discount = 0.0;
        $couponCode = $request->session()->get('cart.coupon_code');

        if ($couponCode) {
            $result = app(CouponDiscountService::class)->validateCode($couponCode, (float) $lines->sum('line_total'));

            if ($result['valid'] && $result['coupon']) {
                $coupon = [
                    'code' => $result['coupon']->code,
                    'name' => $result['coupon']->name,
                ];
                $discount = $result['discount'];
            } else {
                $request->session()->forget('cart.coupon_code');
            }
        }

        return [
            'items' => $lines,
            'subtotal' => (float) $lines->sum('line_total'),
            'item_count' => (int) $lines->sum('quantity'),
            'coupon' => $coupon,
            'discount' => $discount,
        ];
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
        ], $data);
    }
}
