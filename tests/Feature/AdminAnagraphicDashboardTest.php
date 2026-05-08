<?php

namespace Tests\Feature;

use App\Models\Anagraphic;
use App\Models\Campaign;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAnagraphicDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_collected_anagraphics_dashboard(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $campaign = Campaign::query()->create(['name' => 'Campagna Sud']);

        Anagraphic::query()->create([
            'name' => 'Mario',
            'surname' => 'Rossi',
            'phone' => '3331234567',
            'mail' => 'mario@example.com',
            'id_campaign' => $campaign->id,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.anagraphics.index'));

        $response->assertOk()
            ->assertSee('Dashboard anagrafiche')
            ->assertSee('Mario Rossi')
            ->assertSee('Campagna Sud')
            ->assertSee('3331234567');
    }
}