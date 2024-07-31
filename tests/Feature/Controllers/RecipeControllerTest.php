<?php

namespace Tests\Feature\Controllers;

use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_recipes()
    {
        Recipe::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/recipes');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_it_can_create_a_recipe()
    {
        Storage::fake('public');

        $data = [
            'name' => 'Test Recipe',
            'ingredients' => 'Test Ingredients that are at least 10 characters',
            'instructions' => 'Test Instructions that are at least 10 characters',
            'cuisine_type' => 'Test Cuisine',
            'image' => UploadedFile::fake()->image('recipe.jpg', 640, 480)->size(500),
        ];

        $response = $this->postJson('/api/v1/recipes', $data);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Test Recipe']);

        // Check if the image was stored
        Storage::disk('public')->assertExists('images/' . $data['image']->hashName());
    }

    public function test_it_can_show_a_recipe()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->getJson("/api/v1/recipes/{$recipe->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $recipe->name]);
    }

    public function test_it_can_update_a_recipe()
    {
        Storage::fake('public');

        $recipe = Recipe::factory()->create();
        $data = [
            'name' => 'Updated Recipe Name',
            'image' => UploadedFile::fake()->image('new_recipe.jpg', 640, 480)->size(500),
        ];

        $response = $this->putJson("/api/v1/recipes/{$recipe->id}", $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Recipe Name']);

        // Check if the image was stored
        Storage::disk('public')->assertExists('images/' . $data['image']->hashName());
    }

    public function test_it_can_delete_a_recipe()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->deleteJson("/api/v1/recipes/{$recipe->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }

    public function test_it_validates_required_fields_when_creating_a_recipe()
    {
        $response = $this->postJson('/api/v1/recipes', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'ingredients', 'instructions', 'cuisine_type']);
    }

    public function test_it_validates_field_types_when_updating_a_recipe()
    {
        $recipe = Recipe::factory()->create();
        $data = [
            'name' => 123,  // should be string
            'ingredients' => [],  // should be string
        ];

        $response = $this->putJson("/api/v1/recipes/{$recipe->id}", $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'ingredients']);
    }
}
