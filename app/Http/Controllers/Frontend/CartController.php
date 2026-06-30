<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Product;
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
        ]);

        $items = $this->cartItems($request);
        $productId = (string) $product->id;
        $items[$productId] = ($items[$productId] ?? 0) + (int) $validated['quantity'];

        $request->session()->put('cart.items', $items);

        return redirect()
            ->route('cart.show')
            ->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $items = $this->cartItems($request);
        $productId = (string) $product->id;

        if (array_key_exists($productId, $items)) {
            $items[$productId] = (int) $validated['quantity'];
            $request->session()->put('cart.items', $items);
        }

        return redirect()
            ->route('cart.show')
            ->with('success', 'Cart updated.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $items = $this->cartItems($request);
        unset($items[(string) $product->id]);

        $request->session()->put('cart.items', $items);

        return redirect()
            ->route('cart.show')
            ->with('success', 'Product removed from cart.');
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
            ->with('primaryImage')
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
