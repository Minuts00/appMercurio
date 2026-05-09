<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
{
    app(PermissionRegistrar::class)->forgetCachedPermissions();
        $guard = 'web';

        $permissions = [
            'manage users',
            'assign supervisor',
            'disable users',
            'edit submitted data',
            'view submitted data',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $guard,
        ]);
        $supervisor = Role::firstOrCreate([
            'name' => 'supervisor',
            'guard_name' => $guard,
        ]);
        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => $guard,
        ]);

        $admin->syncPermissions($permissions);

        $supervisor->syncPermissions([
            'edit submitted data',
            'view submitted data',
        ]);

        $user->syncPermissions([
            'view submitted data',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }    
}
