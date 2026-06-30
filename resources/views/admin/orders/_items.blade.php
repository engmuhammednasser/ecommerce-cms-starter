@if ($order->items->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No order items',
        'message' => 'Order items will appear here when they are stored with the order.',
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th class="text-end">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->product_sku ?: 'Not set' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format((float) $item->unit_price, 2) }}</td>
                    <td class="text-end">{{ number_format((float) $item->line_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
