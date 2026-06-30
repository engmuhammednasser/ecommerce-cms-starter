@if ($categories->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No categories created',
        'message' => 'Create the first catalog category for this store.',
        'actionLabel' => 'Create Category',
        'actionUrl' => route('admin.categories.create'),
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Parent</th>
                    <th>Status</th>
                    <th>Sort</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->parent?->name ?: 'None' }}</td>
                        <td>
                            @include('admin.components.status-badge', ['status' => $category->status])
                        </td>
                        <td>{{ $category->sort_order }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.categories.destroy', $category),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this category?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $categories->links() }}
    </div>
@endif
