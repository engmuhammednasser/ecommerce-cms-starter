<form method="POST" action="{{ route('admin.orders.status.update', $order) }}">
    @csrf
    @method('PATCH')

    @include('admin.components.form.select', [
        'name' => 'status',
        'label' => 'Order Status',
        'selected' => $order->status,
        'required' => true,
        'placeholder' => 'Choose status',
        'options' => \App\Models\Order::STATUSES,
    ])

    @include('admin.components.form.select', [
        'name' => 'payment_status',
        'label' => 'Payment Status',
        'selected' => $order->payment_status,
        'required' => true,
        'placeholder' => 'Choose payment status',
        'options' => \App\Models\Order::PAYMENT_STATUSES,
    ])

    @include('admin.components.form.select', [
        'name' => 'fulfillment_status',
        'label' => 'Fulfillment Status',
        'selected' => $order->fulfillment_status ?? 'unfulfilled',
        'required' => true,
        'placeholder' => 'Choose fulfillment status',
        'options' => \App\Models\Order::FULFILLMENT_STATUSES,
    ])

    @include('admin.components.form.textarea', [
        'name' => 'admin_notes',
        'label' => 'Admin Notes',
        'value' => $order->admin_notes,
        'rows' => 4,
    ])

    <button type="submit" class="btn btn-primary w-100">Update Order</button>
</form>
