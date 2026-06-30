@if ($orders->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No orders found',
        'message' => 'Orders created from checkout will appear here.',
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>
                            <div>{{ $order->customer_name }}</div>
                            <div class="text-muted small">{{ $order->customer_email ?: 'No email' }}</div>
                        </td>
                        <td>{{ $order->items_count }}</td>
                        <td>{{ number_format((float) $order->total, 2) }}</td>
                        <td>@include('admin.components.status-badge', ['status' => $order->status])</td>
                        <td>{{ $order->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $orders->links() }}
    </div>
@endif
