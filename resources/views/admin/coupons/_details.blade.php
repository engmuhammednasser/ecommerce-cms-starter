<dl class="row mb-0">
    <dt class="col-sm-4">Code</dt>
    <dd class="col-sm-8"><span class="badge text-bg-light border">{{ $coupon->code }}</span></dd>

    <dt class="col-sm-4">Name</dt>
    <dd class="col-sm-8">{{ $coupon->name ?: 'None' }}</dd>

    <dt class="col-sm-4">Discount</dt>
    <dd class="col-sm-8">
        @if ($coupon->discount_type === 'percentage')
            {{ number_format((float) $coupon->discount_value, 2) }}%
        @else
            {{ number_format((float) $coupon->discount_value, 2) }}
        @endif
    </dd>

    <dt class="col-sm-4">Minimum Order</dt>
    <dd class="col-sm-8">{{ number_format((float) $coupon->minimum_order_amount, 2) }}</dd>

    <dt class="col-sm-4">Usage</dt>
    <dd class="col-sm-8">{{ $coupon->used_count }} / {{ $coupon->usage_limit ?: 'Unlimited' }}</dd>

    <dt class="col-sm-4">Active Dates</dt>
    <dd class="col-sm-8">
        {{ $coupon->starts_at?->format('Y-m-d H:i') ?: 'Any time' }}
        -
        {{ $coupon->ends_at?->format('Y-m-d H:i') ?: 'No end date' }}
    </dd>

    <dt class="col-sm-4">Status</dt>
    <dd class="col-sm-8">@include('admin.components.status-badge', ['status' => $coupon->status])</dd>
</dl>
