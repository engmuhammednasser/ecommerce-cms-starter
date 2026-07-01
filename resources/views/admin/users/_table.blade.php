@if ($users->count())
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Created</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @forelse ($user->roles as $role)
                                <span class="badge text-bg-secondary">{{ $role->name }}</span>
                            @empty
                                <span class="text-muted">No role</span>
                            @endforelse
                        </td>
                        <td>{{ $user->created_at?->format('Y-m-d') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">Edit</a>
                            @if (! auth()->user()?->is($user))
                                @include('admin.components.confirm-delete', [
                                    'action' => route('admin.users.destroy', $user),
                                    'label' => 'Delete',
                                    'buttonClass' => 'btn btn-sm btn-outline-danger',
                                    'message' => 'Delete this admin user?',
                                ])
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-3">
        {{ $users->links() }}
    </div>
@else
    @include('admin.components.empty-state', [
        'title' => 'No admin users found',
        'message' => 'Create an admin user and assign at least one role.',
        'actionLabel' => 'Create Admin User',
        'actionUrl' => route('admin.users.create'),
    ])
@endif
