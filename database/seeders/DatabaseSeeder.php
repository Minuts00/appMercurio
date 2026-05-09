<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user->assignRole($adminRole);
        $this->call(RolePermissionSeeder::class);
    }
}
