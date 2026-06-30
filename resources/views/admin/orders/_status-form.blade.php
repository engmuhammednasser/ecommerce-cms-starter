<form method="POST" action="{{ route('admin.orders.status.update', $order) }}">
    @csrf
    @method('PATCH')

    @include('admin.components.form.select', [
        'name' => 'status',
        'label' => 'Status',
        'selected' => $order->status,
        'required' => true,
        'placeholder' => 'Choose status',
        'options' => \App\Models\Order::STATUSES,
    ])

    @include('admin.components.form.textarea', [
        'name' => 'admin_notes',
        'label' => 'Admin Notes',
        'value' => $order->admin_notes,
        'rows' => 4,
    ])

    <button type="submit" class="btn btn-primary w-100">Update Order</button>
</form>
