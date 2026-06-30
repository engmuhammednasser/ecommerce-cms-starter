<dl class="row mb-0">
    <dt class="col-sm-6">Subtotal</dt>
    <dd class="col-sm-6 text-sm-end">{{ number_format((float) $order->subtotal, 2) }}</dd>

    <dt class="col-sm-6">Shipping</dt>
    <dd class="col-sm-6 text-sm-end">{{ number_format((float) $order->shipping_amount, 2) }}</dd>

    <dt class="col-sm-6">Tax</dt>
    <dd class="col-sm-6 text-sm-end">{{ number_format((float) $order->tax_amount, 2) }}</dd>

    <dt class="col-sm-6">Payment</dt>
    <dd class="col-sm-6 text-sm-end">{{ $order->payment_method === 'cash_on_delivery' ? 'Cash on delivery' : 'Not set' }}</dd>

    <dt class="col-sm-6">Total</dt>
    <dd class="col-sm-6 text-sm-end fw-semibold">{{ number_format((float) $order->total, 2) }}</dd>
</dl>
