@if ($attributes->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No attributes created',
        'message' => 'Create attributes such as size, color, or material.',
        'actionLabel' => 'Create Attribute',
        'actionUrl' => route('admin.attributes.create'),
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Type</th>
                    <th>Values</th>
                    <th>Status</th>
                    <th>Sort</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attributes as $attribute)
                    <tr>
                        <td>{{ $attribute->name }}</td>
                        <td>{{ $attribute->slug }}</td>
                        <td>{{ \App\Models\ProductAttribute::TYPES[$attribute->type] ?? $attribute->type }}</td>
                        <td>{{ $attribute->values_count }}</td>
                        <td>@include('admin.components.status-badge', ['status' => $attribute->status])</td>
                        <td>{{ $attribute->sort_order }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.attributes.show', $attribute) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.attributes.edit', $attribute) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.attributes.destroy', $attribute),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this attribute?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $attributes->links() }}
    </div>
@endif
