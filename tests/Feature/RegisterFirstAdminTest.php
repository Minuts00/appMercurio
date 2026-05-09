<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterFirstAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_is_available_only_when_no_users_exist(): void
    {
        $response = $this->get(route('register.create'));
        $response->assertOk();

        User::factory()->create();

        $response = $this->get(route('register.create'));
        $response->assertRedirect('/');
    }

    public function test_can_register_first_user_as_admin(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $response = $this->post(route('register.store'), [
            'email' => 'admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/');

        $user = User::query()->where('email', 'admin@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('admin'));
    }
}