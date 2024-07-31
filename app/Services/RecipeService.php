<?php

namespace App\Services;

use App\Models\Recipe;

class RecipeService extends BaseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        Recipe $recipe
    )
    {
        parent::__construct($recipe);
    }

    public function orderBy(string $criteria, string $order): array
    {
        return $this->model->orderBy($criteria, $order)->get();
    }
}
