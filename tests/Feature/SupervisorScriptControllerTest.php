<?php

namespace Tests\Feature;

use App\Models\Campaign;
use App\Models\Category;
use App\Models\Objection;
use App\Models\Script;
use App\Models\Subcategory;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupervisorScriptControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_supervisor_can_store_script(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $supervisor = User::factory()->create();
        $supervisor->assignRole('supervisor');

        $campaign = Campaign::query()->create(['name' => 'Campagna Sud']);
        $category = Category::query()->create(['name' => 'Ingresso']);
        $subcategory = Subcategory::query()->create([
            'name' => 'Prospezione fredda',
            'id_category' => $category->id,
        ]);

        $response = $this->actingAs($supervisor)->postJson(route('supervisor.scripts.store'), [
            'id_category' => $category->id,
            'id_subcategory' => $subcategory->id,
            'responses' => 'Buongiorno, la contatto per...',
            'id_campaign' => $campaign->id,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.id_category', $category->id)
            ->assertJsonPath('data.id_subcategory', $subcategory->id);

        $this->assertDatabaseCount('scripts', 1);
        $this->assertInstanceOf(Script::class, Script::query()->first());
    }

    public function test_supervisor_can_store_objection_response(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $supervisor = User::factory()->create();
        $supervisor->assignRole('supervisor');

        $campaign = Campaign::query()->create(['name' => 'Campagna Centro']);
        $category = Category::query()->create(['name' => 'Prezzo']);
        $subcategory = Subcategory::query()->create([
            'name' => 'Troppo caro',
            'id_category' => $category->id,
        ]);

        $response = $this->actingAs($supervisor)->postJson(route('supervisor.objections.store'), [
            'id_category' => $category->id,
            'id_subcategory' => $subcategory->id,
            'responses' => 'Capisco, proprio per questo abbiamo...',
            'id_campaign' => $campaign->id,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.id_category', $category->id)
            ->assertJsonPath('data.id_subcategory', $subcategory->id);

        $this->assertDatabaseCount('objections', 1);
        $this->assertInstanceOf(Objection::class, Objection::query()->first());
    }

    public function test_script_creation_fails_if_subcategory_does_not_belong_to_category(): void
    {
        $this->seed(RolePermissionSeeder::class);

        $supervisor = User::factory()->create();
        $supervisor->assignRole('supervisor');

        $campaign = Campaign::query()->create(['name' => 'Campagna Isole']);
        $categoryA = Category::query()->create(['name' => 'Ingresso']);
        $categoryB = Category::query()->create(['name' => 'Fine chiamata']);
        $subcategoryOfB = Subcategory::query()->create([
            'name' => 'Chiusura appuntamento',
            'id_category' => $categoryB->id,
        ]);

        $response = $this->actingAs($supervisor)->postJson(route('supervisor.scripts.store'), [
            'id_category' => $categoryA->id,
            'id_subcategory' => $subcategoryOfB->id,
            'responses' => 'Testo script',
            'id_campaign' => $campaign->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id_subcategory']);
    }
}