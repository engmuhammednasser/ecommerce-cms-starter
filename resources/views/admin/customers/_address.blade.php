@php
    $latestOrder = $customer->orders->first();
@endphp

@if ($latestOrder)
    <dl class="row mb-0">
        <dt class="col-sm-4">Name</dt>
        <dd class="col-sm-8">{{ $latestOrder->customer_name }}</dd>

        <dt class="col-sm-4">Email</dt>
        <dd class="col-sm-8">{{ $latestOrder->customer_email ?: 'Not set' }}</dd>

        <dt class="col-sm-4">Phone</dt>
        <dd class="col-sm-8">{{ $latestOrder->customer_phone ?: 'Not set' }}</dd>

        <dt class="col-sm-4">Address</dt>
        <dd class="col-sm-8">{!! nl2br(e($latestOrder->customer_address)) !!}</dd>
    </dl>
@else
    @include('admin.components.empty-state', [
        'title' => 'No checkout address',
        'message' => 'Checkout address data will appear after this customer places an order.',
    ])
@endif
