<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    /**
     * Decrease stock for all items in an order.
     * Stock cannot go below zero.
     */
    public function decreaseStockForOrder(Order $order): void
    {
        $order->loadMissing('items');

        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            if ($item->variant_id) {
                \App\Models\ProductVariant::query()
                    ->where('id', $item->variant_id)
                    ->where('stock_quantity', '>=', $item->quantity)
                    ->update([
                        'stock_quantity' => DB::raw("stock_quantity - {$item->quantity}"),
                    ]);
            } else {
                Product::query()
                    ->where('id', $item->product_id)
                    ->where('stock_quantity', '>=', $item->quantity)
                    ->update([
                        'stock_quantity' => DB::raw("stock_quantity - {$item->quantity}"),
                    ]);
            }
        }
    }

    /**
     * Restore stock for all items in an order (e.g. on cancellation/refund).
     */
    public function restoreStockForOrder(Order $order): void
    {
        $order->loadMissing('items');

        foreach ($order->items as $item) {
            if (! $item->product_id) {
                continue;
            }

            if ($item->variant_id) {
                \App\Models\ProductVariant::query()
                    ->where('id', $item->variant_id)
                    ->update([
                        'stock_quantity' => DB::raw("stock_quantity + {$item->quantity}"),
                    ]);
            } else {
                Product::query()
                    ->where('id', $item->product_id)
                    ->update([
                        'stock_quantity' => DB::raw("stock_quantity + {$item->quantity}"),
                    ]);
            }
        }
    }

    /**
     * Check if all items in a cart have sufficient stock.
     *
     * @param \Illuminate\Support\Collection $cartItems
     * @return array{sufficient: bool, insufficient: array<int, array{product: Product, requested: int, available: int}>}
     */
    public function checkStock($cartItems): array
    {
        $insufficient = [];

        foreach ($cartItems as $line) {
            $product = $line['product'];
            $variant = $line['variant'] ?? null;
            $available = $variant ? $variant->stock_quantity : $product->stock_quantity;
            $name = $variant ? $product->name . ' - ' . $variant->label() : $product->name;

            if ($available < $line['quantity']) {
                $insufficient[] = [
                    'product' => $product,
                    'variant' => $variant,
                    'name' => $name,
                    'requested' => $line['quantity'],
                    'available' => $available,
                ];
            }
        }

        return [
            'sufficient' => empty($insufficient),
            'insufficient' => $insufficient,
        ];
    }
}
