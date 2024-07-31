<?php

namespace App\Services;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Collection;

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

    public function orderBy(string $criteria, string $order): array | Collection
    {
        return $this->model->orderBy($criteria, $order)->get();
    }
}
