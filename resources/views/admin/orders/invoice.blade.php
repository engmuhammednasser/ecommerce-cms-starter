<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Order #{{ $order->order_number }}</title>
    @vite(['resources/css/admin.css'])
    <style>
        body { background: white; padding: 2rem; color: #333; }
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
        .invoice-box { max-width: 800px; margin: auto; }
        .invoice-header { display: flex; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .invoice-header h1 { font-size: 2.5rem; font-weight: bold; color: #1f2937; margin: 0; }
        .invoice-details { text-align: right; }
        .invoice-details h2 { margin: 0; color: #4b5563; font-size: 1.25rem; }
        .invoice-details p { margin: 5px 0 0; color: #6b7280; font-size: 0.875rem; }
        .customer-info { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .customer-info > div { flex: 1; }
        .customer-info h3 { font-size: 1rem; font-weight: bold; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; color: #374151; }
        .customer-info p { margin: 0; line-height: 1.6; color: #4b5563; font-size: 0.875rem; white-space: pre-wrap; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; font-size: 0.875rem; }
        th { font-weight: bold; color: #374151; background-color: #f9fafb; }
        .text-right { text-align: right; }
        .totals-row { display: flex; justify-content: flex-end; }
        .totals-table { width: 300px; }
        .totals-table th, .totals-table td { padding: 8px 12px; border: none; }
        .totals-table th { background: transparent; text-align: left; font-weight: normal; color: #6b7280; }
        .totals-table td { text-align: right; color: #1f2937; }
        .totals-table .grand-total th, .totals-table .grand-total td { font-weight: bold; font-size: 1.125rem; border-top: 2px solid #eee; padding-top: 12px; }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-box">
        <div class="no-print mb-4 flex justify-between">
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">Back to Order</a>
            <button onclick="window.print()" class="btn btn-primary">Print Invoice</button>
        </div>

        <div class="invoice-header">
            <div>
                <h1>INVOICE</h1>
                @if (setting('general.logo'))
                    <img src="{{ asset('storage/' . setting('general.logo')) }}" alt="{{ setting('general.site_name') }}" style="max-height: 50px; margin-top: 15px;">
                @else
                    <p style="font-size: 1.25rem; font-weight: bold; margin-top: 10px; color: #111827;">{{ setting('general.site_name', config('app.name')) }}</p>
                @endif
            </div>
            <div class="invoice-details">
                <h2>Order #{{ $order->order_number }}</h2>
                <p>Date: {{ $order->created_at->format('M j, Y') }}</p>
                <p>Payment: {{ \App\Models\Order::PAYMENT_STATUSES[$order->payment_status] ?? $order->payment_status }}</p>
            </div>
        </div>

        <div class="customer-info">
            <div style="margin-right: 40px;">
                <h3>Bill To</h3>
                <p>{{ $order->customer_name }}
@if($order->customer_email){{ $order->customer_email }}
@endif
@if($order->customer_phone){{ $order->customer_phone }}@endif</p>
            </div>
            <div>
                <h3>Ship To</h3>
                <p>{{ $order->customer_address }}</p>
                @if($order->shipping_rate_name)
                    <p style="margin-top: 10px; font-style: italic; color: #6b7280;">Via {{ $order->shipping_rate_name }}</p>
                @endif
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product_name }}</strong>
                            @if ($item->variant_label)
                                <br><span style="color: #6b7280; font-size: 0.75rem;">{{ $item->variant_label }}</span>
                            @endif
                            <br><span style="color: #9ca3af; font-size: 0.75rem;">SKU: {{ $item->product_sku }}</span>
                        </td>
                        <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->line_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals-row">
            <table class="totals-table">
                <tr>
                    <th>Subtotal</th>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                @if ($order->discount_amount > 0)
                    <tr>
                        <th>Discount ({{ $order->coupon_code }})</th>
                        <td>-${{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Shipping</th>
                    <td>${{ number_format($order->shipping_amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Tax</th>
                    <td>${{ number_format($order->tax_amount, 2) }}</td>
                </tr>
                <tr class="grand-total">
                    <th>Total</th>
                    <td>${{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>
        
        @if ($order->notes)
            <div style="margin-top: 40px; padding: 15px; background: #f9fafb; border-radius: 8px;">
                <h3 style="font-size: 0.875rem; font-weight: bold; margin-bottom: 5px; color: #374151;">Customer Note:</h3>
                <p style="margin: 0; color: #4b5563; font-size: 0.875rem; white-space: pre-wrap;">{{ $order->notes }}</p>
            </div>
        @endif
    </div>
</body>
</html>
