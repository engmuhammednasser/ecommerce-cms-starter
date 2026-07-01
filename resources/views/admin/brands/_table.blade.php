@if ($brands->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No brands created',
        'message' => 'Create brands to organize catalog products.',
        'actionLabel' => 'Create Brand',
        'actionUrl' => route('admin.brands.create'),
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th>Status</th>
                    <th>Sort</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->slug }}</td>
                        <td>{{ $brand->products_count }}</td>
                        <td>@include('admin.components.status-badge', ['status' => $brand->status])</td>
                        <td>{{ $brand->sort_order }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.brands.show', $brand) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.brands.destroy', $brand),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this brand?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $brands->links() }}
    </div>
@endif
