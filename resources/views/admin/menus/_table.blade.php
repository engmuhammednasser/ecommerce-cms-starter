@if ($menus->isEmpty())
    @include('admin.components.empty-state', [
        'title' => 'No menus created',
        'message' => 'Create Header, Footer, or Mobile menus for database-driven navigation.',
        'actionLabel' => 'Create Menu',
        'actionUrl' => route('admin.menus.create'),
    ])
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Location</th>
                    <th>Items</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $menu->name }}</td>
                        <td>{{ $menu->slug }}</td>
                        <td>{{ $menu->locationLabel() }}</td>
                        <td>{{ $menu->items_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.menus.show', $menu) }}" class="btn btn-sm btn-outline-secondary">Manage</a>
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @include('admin.components.confirm-delete', [
                                'action' => route('admin.menus.destroy', $menu),
                                'label' => 'Delete',
                                'buttonClass' => 'btn btn-sm btn-outline-danger',
                                'message' => 'Delete this menu and all its items?',
                            ])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $menus->links() }}
    </div>
@endif
