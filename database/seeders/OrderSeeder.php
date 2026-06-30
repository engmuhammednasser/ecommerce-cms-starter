<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = Customer::query()->where('email', 'jordan@example.com')->first();
        $products = Product::query()
            ->whereIn('slug', ['city-backpack', 'desk-lamp'])
            ->get()
            ->keyBy('slug');

        if (! $customer || $products->isEmpty()) {
            return;
        }

        $subtotal = 0.0;
        $lines = [];

        foreach ([['slug' => 'city-backpack', 'quantity' => 1], ['slug' => 'desk-lamp', 'quantity' => 2]] as $line) {
            $product = $products->get($line['slug']);

            if (! $product) {
                continue;
            }

            $unitPrice = (float) ($product->sale_price ?: $product->price);
            $lineTotal = $unitPrice * $line['quantity'];
            $subtotal += $lineTotal;

            $lines[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'quantity' => $line['quantity'],
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
            ];
        }

        $shipping = 0.0;
        $tax = round($subtotal * 0.05, 2);

        $order = Order::query()->updateOrCreate(
            ['order_number' => 'ORD-DEMO-1001'],
            [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone,
                'customer_address' => "100 Demo Street\nStarter City",
                'notes' => 'Demo order created by the database seeder.',
                'admin_notes' => 'Use this order to preview the admin order details screen.',
                'status' => 'processing',
                'payment_method' => 'cash_on_delivery',
                'subtotal' => $subtotal,
                'shipping_amount' => $shipping,
                'tax_amount' => $tax,
                'total' => $subtotal + $shipping + $tax,
            ],
        );

        foreach ($lines as $line) {
            $order->items()->updateOrCreate(
                ['product_id' => $line['product_id']],
                $line,
            );
        }
    }
}
