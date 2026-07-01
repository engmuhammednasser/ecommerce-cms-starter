@if ($coupons->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No coupons created',
        'message' => 'Create discount coupons for the storefront cart and checkout.',
        'actionLabel' => 'Create Coupon',
        'actionUrl' => route('admin.coupons.create'),
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Discount</th>
                    <th>Minimum</th>
                    <th>Usage</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr>
                        <td><span class="badge text-bg-light border">{{ $coupon->code }}</span></td>
                        <td>{{ $coupon->name ?: 'None' }}</td>
                        <td>
                            @if ($coupon->discount_type === 'percentage')
                                {{ number_format((float) $coupon->discount_value, 2) }}%
                            @else
                                {{ number_format((float) $coupon->discount_value, 2) }}
                            @endif
                        </td>
                        <td>{{ number_format((float) $coupon->minimum_order_amount, 2) }}</td>
                        <td>{{ $coupon->used_count }} / {{ $coupon->usage_limit ?: 'Unlimited' }}</td>
                        <td>@include('admin.components.status-badge', ['status' => $coupon->status])</td>
                        <td class="text-end">
                            <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.coupons.destroy', $coupon),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this coupon?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $coupons->links() }}
    </div>
@endif
