<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
{
    $permissions = [
        'manage users',
        'assign supervisor',
        'disable users',
        'edit submitted data',
        'view submitted data',
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    $admin = Role::firstOrCreate(['name' => 'admin']);
    $supervisor = Role::firstOrCreate(['name' => 'supervisor']);
    $user = Role::firstOrCreate(['name' => 'user']);

    $admin->syncPermissions($permissions);

    $supervisor->syncPermissions([
        'edit submitted data',
        'view submitted data',
    ]);

    $user->syncPermissions([
        'view submitted data',
    ]);
}
}