<dl class="row mb-0">
    <dt class="col-sm-4">Name</dt>
    <dd class="col-sm-8">{{ $order->customer_name }}</dd>

    <dt class="col-sm-4">Email</dt>
    <dd class="col-sm-8">{{ $order->customer_email ?: 'Not set' }}</dd>

    <dt class="col-sm-4">Phone</dt>
    <dd class="col-sm-8">{{ $order->customer_phone ?: 'Not set' }}</dd>

    <dt class="col-sm-4">Shipping Address</dt>
    <dd class="col-sm-8">{!! nl2br(e($order->customer_address)) !!}</dd>
</dl>
