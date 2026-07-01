<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->with('roles')
            ->whereHas('roles')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'user' => new User(),
            'roles' => $this->roleOptions(),
            'selectedRoles' => [],
        ]);
    }

    public function store(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $data = $this->validatedData($request);
        $roleIds = $data['role_ids'];
        unset($data['role_ids']);

        $user = User::query()->create($data);
        $user->roles()->sync($roleIds);
        $activityLogger->log('admin_user_created', $user);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Admin user created successfully.');
    }

    public function show(User $user): View
    {
        $user->load('roles.permissions');

        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $user->load('roles');

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->roleOptions(),
            'selectedRoles' => $user->roles->pluck('id')->all(),
        ]);
    }

    public function update(Request $request, User $user, ActivityLogger $activityLogger): RedirectResponse
    {
        $data = $this->validatedData($request, $user);
        $roleIds = $data['role_ids'];
        unset($data['role_ids']);

        if (($data['password'] ?? '') === '') {
            unset($data['password']);
        }

        $user->update($data);
        $user->roles()->sync($roleIds);
        $activityLogger->log('admin_user_updated', $user);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Admin user updated successfully.');
    }

    public function destroy(Request $request, User $user, ActivityLogger $activityLogger): RedirectResponse
    {
        if ($request->user()?->is($user)) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'You cannot delete your own admin account.');
        }

        $activityLogger->log('admin_user_deleted', $user);
        $user->roles()->detach();
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Admin user deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?User $user = null): array
    {
        $passwordRules = $user
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'password' => $passwordRules,
            'role_ids' => ['required', 'array', 'min:1'],
            'role_ids.*' => ['integer', Rule::exists('roles', 'id')],
        ]);
    }

    /**
     * @return array<int, string>
     */
    private function roleOptions(): array
    {
        return Role::query()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }
}
