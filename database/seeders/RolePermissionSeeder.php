<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    /**
     * @var array<int, string>
     */
    private array $roles = [
        'Super Admin',
        'Admin',
        'Content Manager',
        'Order Manager',
        'Product Manager',
    ];

    /**
     * @var array<int, string>
     */
    private array $permissions = [
        'manage products',
        'manage orders',
        'manage pages',
        'manage settings',
        'manage users',
        'manage media',
        'manage menus',
        'manage appearance',
    ];

    public function run(): void
    {
        $permissions = collect($this->permissions)
            ->mapWithKeys(function (string $name): array {
                $permission = Permission::updateOrCreate(
                    ['slug' => Str::slug($name)],
                    ['name' => $name],
                );

                return [$permission->slug => $permission->id];
            });

        foreach ($this->roles as $name) {
            $role = Role::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name],
            );

            if ($role->slug === 'super-admin') {
                $role->permissions()->sync($permissions->values()->all());
            }
        }
    }
}
