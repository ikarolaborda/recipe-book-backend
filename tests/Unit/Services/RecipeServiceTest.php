<?php

namespace Tests\Unit\Services;

use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RecipeService $recipeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->recipeService = new RecipeService(new Recipe());
    }

    public function test_it_can_get_all_recipes()
    {
        Recipe::factory()->count(3)->create();

        $recipes = $this->recipeService->all();

        $this->assertCount(3, $recipes);
    }

    public function test_it_can_create_a_recipe()
    {
        $data = [
            'name' => 'Test Recipe',
            'ingredients' => 'Test Ingredients',
            'instructions' => 'Test Instructions',
            'cuisine_type' => 'Test Cuisine',
        ];

        $recipe = $this->recipeService->create($data);

        $this->assertInstanceOf(Recipe::class, $recipe);
        $this->assertEquals($data['name'], $recipe->name);
    }

    public function test_it_can_update_a_recipe()
    {
        $recipe = Recipe::factory()->create();
        $data = ['name' => 'Updated Recipe Name'];

        $updatedRecipe = $this->recipeService->update($data, $recipe->id);

        $this->assertEquals('Updated Recipe Name', $updatedRecipe->name);
    }

    public function test_it_can_delete_a_recipe()
    {
        $recipe = Recipe::factory()->create();

        $this->recipeService->delete($recipe->id);

        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }

    public function test_it_can_order_recipes()
    {
        Recipe::factory()->create(['name' => 'B Recipe']);
        Recipe::factory()->create(['name' => 'A Recipe']);
        Recipe::factory()->create(['name' => 'C Recipe']);

        $orderedRecipes = $this->recipeService->orderBy('name', 'asc');

        $this->assertInstanceOf(Collection::class, $orderedRecipes);
        $this->assertEquals('A Recipe', $orderedRecipes[0]->name);
        $this->assertEquals('C Recipe', $orderedRecipes[2]->name);
    }
}
