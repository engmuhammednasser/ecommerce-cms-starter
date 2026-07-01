<dl class="row mb-4">
    <dt class="col-sm-3">Name</dt>
    <dd class="col-sm-9">{{ $attribute->name }}</dd>

    <dt class="col-sm-3">Slug</dt>
    <dd class="col-sm-9">{{ $attribute->slug }}</dd>

    <dt class="col-sm-3">Type</dt>
    <dd class="col-sm-9">{{ \App\Models\ProductAttribute::TYPES[$attribute->type] ?? $attribute->type }}</dd>

    <dt class="col-sm-3">Status</dt>
    <dd class="col-sm-9">@include('admin.components.status-badge', ['status' => $attribute->status])</dd>
</dl>

<h3 class="h6">Values</h3>
@if ($attribute->values->isEmpty())
    <p class="text-muted mb-0">No values created.</p>
@else
    <div class="d-flex flex-wrap gap-2">
        @foreach ($attribute->values as $value)
            <span class="badge text-bg-light border">{{ $value->value }}</span>
        @endforeach
    </div>
@endif
