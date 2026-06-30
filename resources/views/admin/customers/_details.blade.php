<dl class="row mb-0">
    <dt class="col-sm-4">Name</dt>
    <dd class="col-sm-8">{{ $customer->name }}</dd>

    <dt class="col-sm-4">Email</dt>
    <dd class="col-sm-8">{{ $customer->email ?: 'Not set' }}</dd>

    <dt class="col-sm-4">Phone</dt>
    <dd class="col-sm-8">{{ $customer->phone ?: 'Not set' }}</dd>

    <dt class="col-sm-4">Status</dt>
    <dd class="col-sm-8">@include('admin.components.status-badge', ['status' => $customer->status])</dd>

    <dt class="col-sm-4">Created</dt>
    <dd class="col-sm-8">{{ $customer->created_at?->format('Y-m-d H:i') }}</dd>
</dl>
