<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function index(): View
    {
        return view('admin.exports.index', [
            'productsCount' => Product::query()->count(),
            'ordersCount' => Order::query()->count(),
            'customersCount' => Customer::query()->count(),
        ]);
    }

    public function products(): StreamedResponse
    {
        return $this->csvDownload('products.csv', [
            'ID',
            'Name',
            'Slug',
            'SKU',
            'Category',
            'Price',
            'Sale Price',
            'Stock Quantity',
            'Status',
            'Featured',
            'SEO Title',
            'SEO Description',
            'SEO Image',
            'Created At',
            'Updated At',
        ], Product::query()->with('category')->orderBy('id'), function (Product $product): array {
            return [
                $product->id,
                $product->name,
                $product->slug,
                $product->sku,
                $product->category?->name,
                $product->price,
                $product->sale_price,
                $product->stock_quantity,
                $product->status,
                $product->featured ? 'yes' : 'no',
                $product->seo_title,
                $product->seo_description,
                $product->seo_image,
                $product->created_at?->toDateTimeString(),
                $product->updated_at?->toDateTimeString(),
            ];
        });
    }

    public function orders(): StreamedResponse
    {
        return $this->csvDownload('orders.csv', [
            'ID',
            'Order Number',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Customer Address',
            'Status',
            'Payment Method',
            'Subtotal',
            'Shipping Amount',
            'Tax Amount',
            'Total',
            'Notes',
            'Admin Notes',
            'Created At',
            'Updated At',
        ], Order::query()->orderBy('id'), function (Order $order): array {
            return [
                $order->id,
                $order->order_number,
                $order->customer_name,
                $order->customer_email,
                $order->customer_phone,
                $order->customer_address,
                $order->status,
                $order->payment_method,
                $order->subtotal,
                $order->shipping_amount,
                $order->tax_amount,
                $order->total,
                $order->notes,
                $order->admin_notes,
                $order->created_at?->toDateTimeString(),
                $order->updated_at?->toDateTimeString(),
            ];
        });
    }

    public function customers(): StreamedResponse
    {
        return $this->csvDownload('customers.csv', [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Status',
            'Created At',
            'Updated At',
        ], Customer::query()->orderBy('id'), function (Customer $customer): array {
            return [
                $customer->id,
                $customer->name,
                $customer->email,
                $customer->phone,
                $customer->status,
                $customer->created_at?->toDateTimeString(),
                $customer->updated_at?->toDateTimeString(),
            ];
        });
    }

    /**
     * @param array<int, string> $headers
     * @param Builder<\Illuminate\Database\Eloquent\Model> $query
     * @param callable(\Illuminate\Database\Eloquent\Model): array<int, mixed> $rowMapper
     */
    private function csvDownload(string $filename, array $headers, Builder $query, callable $rowMapper): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $query, $rowMapper): void {
            $output = fopen('php://output', 'w');

            if ($output === false) {
                return;
            }

            fputcsv($output, $headers);

            $query->chunk(200, function ($records) use ($output, $rowMapper): void {
                foreach ($records as $record) {
                    fputcsv($output, $rowMapper($record));
                }
            });

            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Cache-Control' => 'no-store, no-cache',
        ]);
    }
}
