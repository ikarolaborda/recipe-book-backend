<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'ingredients' => $this->faker->paragraphs(2, true),
            'instructions' => $this->faker->paragraphs(3, true),
            'cuisine_type' => $this->faker->randomElement(['Italian', 'French', 'Japanese', 'Indian', 'Mexican', 'Chinese']),
            'image' => $this->faker->imageUrl(640, 480, 'food'), // This generates a URL to a random food image
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
