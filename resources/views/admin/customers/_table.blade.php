@if ($customers->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No customers found',
        'message' => 'Customers created from checkout will appear here.',
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Orders</th>
                    <th>Total Spend</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email ?: 'Not set' }}</td>
                        <td>{{ $customer->phone ?: 'Not set' }}</td>
                        <td>@include('admin.components.status-badge', ['status' => $customer->status])</td>
                        <td>{{ $customer->orders_count }}</td>
                        <td>{{ number_format((float) ($customer->orders_sum_total ?? 0), 2) }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $customers->links() }}
    </div>
@endif
