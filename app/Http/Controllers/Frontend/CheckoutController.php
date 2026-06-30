<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $cart = $this->cartSummary($request);

        if ($cart['items']->isEmpty()) {
            return redirect()->route('cart.show');
        }

        return view('frontend.themes.default.checkout', $this->themeData([
            'title' => setting('checkout.title', 'Checkout'),
            'metaTitle' => setting('checkout.title', setting('general.site_name', config('app.name', 'Laravel'))),
            'cart' => $cart,
            'totals' => $this->checkoutTotals($cart['subtotal']),
            'cashOnDeliveryEnabled' => $this->cashOnDeliveryEnabled(),
        ]));
    }

    public function store(Request $request, OrderNotificationService $notifications): RedirectResponse
    {
        $cart = $this->cartSummary($request);

        if ($cart['items']->isEmpty()) {
            return redirect()->route('cart.show');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:255'],
            'customer_address' => ['required', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'string', 'in:cash_on_delivery'],
        ]);

        abort_unless($this->cashOnDeliveryEnabled(), 422);

        $totals = $this->checkoutTotals($cart['subtotal']);

        $order = DB::transaction(function () use ($validated, $cart, $totals): Order {
            $customer = Customer::create([
                'name' => $validated['customer_name'],
                'email' => $validated['customer_email'] ?? null,
                'phone' => $validated['customer_phone'] ?? null,
                'status' => 'guest',
            ]);

            $order = Order::create([
                'customer_id' => $customer->id,
                'order_number' => $this->orderNumber(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'customer_address' => $validated['customer_address'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'subtotal' => $cart['subtotal'],
                'shipping_amount' => $totals['shipping'],
                'tax_amount' => $totals['tax'],
                'total' => $totals['total'],
            ]);

            foreach ($cart['items'] as $line) {
                $product = $line['product'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $line['quantity'],
                    'unit_price' => $line['unit_price'],
                    'line_total' => $line['line_total'],
                ]);
            }

            return $order;
        });

        $request->session()->forget('cart.items');
        $notifications->orderPlaced($order);

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order): View
    {
        $order->load('items');

        return view('frontend.themes.default.order-success', $this->themeData([
            'title' => setting('checkout.success_title', 'Order received'),
            'metaTitle' => setting('checkout.success_title', setting('general.site_name', config('app.name', 'Laravel'))),
            'order' => $order,
        ]));
    }

    /**
     * @return array<string, int>
     */
    private function cartItems(Request $request): array
    {
        return collect($request->session()->get('cart.items', []))
            ->mapWithKeys(fn ($quantity, $productId): array => [(string) $productId => max(1, (int) $quantity)])
            ->all();
    }

    /**
     * @return array{items: Collection<int, array<string, mixed>>, subtotal: float, item_count: int}
     */
    private function cartSummary(Request $request): array
    {
        $items = $this->cartItems($request);
        $products = Product::query()
            ->where('status', 'published')
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');

        $lines = collect($items)
            ->map(function (int $quantity, string $productId) use ($products): ?array {
                $product = $products->get((int) $productId);

                if (! $product) {
                    return null;
                }

                $unitPrice = (float) ($product->sale_price ?: $product->price);

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'line_total' => $unitPrice * $quantity,
                ];
            })
            ->filter()
            ->values();

        return [
            'items' => $lines,
            'subtotal' => (float) $lines->sum('line_total'),
            'item_count' => (int) $lines->sum('quantity'),
        ];
    }

    private function orderNumber(): string
    {
        do {
            $number = 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (Order::query()->where('order_number', $number)->exists());

        return $number;
    }

    /**
     * @return array{shipping: float, tax: float, total: float}
     */
    private function checkoutTotals(float $subtotal): array
    {
        $flatRate = max(0, (float) setting('shipping.flat_rate', 0));
        $freeThreshold = setting('shipping.free_shipping_threshold');
        $freeThreshold = $freeThreshold === null || $freeThreshold === '' ? null : max(0, (float) $freeThreshold);
        $shipping = $freeThreshold !== null && $subtotal >= $freeThreshold ? 0.0 : $flatRate;
        $taxRate = max(0, (float) setting('tax.percentage', 0));
        $tax = round($subtotal * ($taxRate / 100), 2);

        return [
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $subtotal + $shipping + $tax,
        ];
    }

    private function cashOnDeliveryEnabled(): bool
    {
        return setting('payment.cash_on_delivery_enabled', '1') === '1';
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
