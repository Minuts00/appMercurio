<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCreateUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user_with_role_and_campaign(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $campaign = Campaign::query()->create(['name' => 'Campagna Nord']);

        $response = $this->actingAs($admin)->postJson(route('admin.users.store'), [
            'email' => 'new.user@example.com',
            'password' => 'password123',
            'role' => 'user',
            'id_campaign' => $campaign->id,
            'is_active' => true,
        ]);

        $response->assertCreated()
            ->assertJsonPath('user.email', 'new.user@example.com')
            ->assertJsonPath('user.id_campaign', $campaign->id)
            ->assertJsonPath('user.role', 'user');

        $createdUser = User::query()->where('email', 'new.user@example.com')->firstOrFail();

        $this->assertTrue($createdUser->hasRole('user'));
        $this->assertSame($campaign->id, $createdUser->id_campaign);
    }
}