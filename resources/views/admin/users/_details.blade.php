<div class="row">
    <div class="col-lg-6">
        <dl class="row mb-0">
            <dt class="col-sm-4">Name</dt>
            <dd class="col-sm-8">{{ $user->name }}</dd>

            <dt class="col-sm-4">Email</dt>
            <dd class="col-sm-8">{{ $user->email }}</dd>

            <dt class="col-sm-4">Created</dt>
            <dd class="col-sm-8">{{ $user->created_at?->format('Y-m-d H:i') }}</dd>

            <dt class="col-sm-4">Updated</dt>
            <dd class="col-sm-8">{{ $user->updated_at?->format('Y-m-d H:i') }}</dd>
        </dl>
    </div>

    <div class="col-lg-6">
        <h3 class="h6">Roles</h3>
        <div class="mb-3">
            @forelse ($user->roles as $role)
                <span class="badge text-bg-secondary">{{ $role->name }}</span>
            @empty
                <span class="text-muted">No roles assigned.</span>
            @endforelse
        </div>

        <h3 class="h6">Permissions From Roles</h3>
        @php
            $permissions = $user->roles
                ->flatMap(fn ($role) => $role->permissions)
                ->unique('id')
                ->sortBy('name');
        @endphp

        <div class="d-flex flex-wrap gap-2">
            @forelse ($permissions as $permission)
                <span class="badge text-bg-light border">{{ $permission->name }}</span>
            @empty
                <span class="text-muted">No permissions assigned.</span>
            @endforelse
        </div>
    </div>
</div>
