<dl class="row mb-0">
    <dt class="col-sm-4">Customer Notes</dt>
    <dd class="col-sm-8">{!! nl2br(e($order->notes ?: 'Not set')) !!}</dd>

    <dt class="col-sm-4">Admin Notes</dt>
    <dd class="col-sm-8">{!! nl2br(e($order->admin_notes ?: 'Not set')) !!}</dd>
</dl>
