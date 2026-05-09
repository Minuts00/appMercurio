<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);
    
        $adminRole = Role::query()->where('name', 'admin')->where('guard_name', 'web')->first();

        $admin = User::firstOrCreate(
            ['email' => 'admin@appmercurio.local'],
            [
                'password' => Hash::make('ChangeMe1234!'),
                'is_active' => true,
            ]
        );

        if ($adminRole !== null && ! $admin->hasRole($adminRole->name)) {
            $admin->assignRole($adminRole);
        }
    }
}
