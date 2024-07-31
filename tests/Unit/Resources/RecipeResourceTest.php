<?php

namespace Tests\Unit\Resources;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Tests\TestCase;

class RecipeResourceTest extends TestCase
{
    public function test_it_transforms_recipe_to_array()
    {
        $recipe = Recipe::factory()->make([
            'id' => 1,
            'name' => 'Test Recipe',
            'ingredients' => 'Test Ingredients',
            'instructions' => 'Test Instructions',
            'cuisine_type' => 'Test Cuisine',
        ]);

        $resource = new RecipeResource($recipe);
        $resourceArray = $resource->toArray(request());

        $this->assertEquals(1, $resourceArray['id']);
        $this->assertEquals('Test Recipe', $resourceArray['name']);
        $this->assertEquals('Test Ingredients', $resourceArray['ingredients']);
        $this->assertEquals('Test Instructions', $resourceArray['instructions']);
        $this->assertEquals('Test Cuisine', $resourceArray['cuisine_type']);
        $this->assertArrayHasKey('_links', $resourceArray);
    }
}
