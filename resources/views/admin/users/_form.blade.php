@php
    $selectedRoleIds = collect(old('role_ids', $selectedRoles ?? []))
        ->map(fn ($roleId) => (int) $roleId)
        ->all();
@endphp

<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.form.input', [
                'name' => 'name',
                'label' => 'Name',
                'value' => $user->name,
                'required' => true,
            ])

            @include('admin.components.form.input', [
                'name' => 'email',
                'label' => 'Email',
                'type' => 'email',
                'value' => $user->email,
                'required' => true,
            ])

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    @required($method === 'POST')
                    autocomplete="new-password"
                >
                @if ($method !== 'POST')
                    <div class="form-text">Leave blank to keep the current password.</div>
                @endif
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    @required($method === 'POST')
                    autocomplete="new-password"
                >
            </div>
        </div>

        <div class="col-lg-4">
            <div class="mb-3">
                <label for="role_ids" class="form-label">Roles</label>
                <select
                    id="role_ids"
                    name="role_ids[]"
                    class="form-select @error('role_ids') is-invalid @enderror @error('role_ids.*') is-invalid @enderror"
                    multiple
                    required
                    size="{{ max(5, min(8, count($roles))) }}"
                >
                    @foreach ($roles as $roleId => $roleName)
                        <option value="{{ $roleId }}" @selected(in_array((int) $roleId, $selectedRoleIds, true))>
                            {{ $roleName }}
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Hold Ctrl or Cmd to select more than one role.</div>
                @error('role_ids')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('role_ids.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Admin User</button>
    </div>
</form>
