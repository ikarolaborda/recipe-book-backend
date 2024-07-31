<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
            'cuisine_type' => $this->cuisine_type,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '_links' => [
                'self' => [
                    'href' => route('recipes.show', $this->id),
                ],
                'update' => [
                    'href' => route('recipes.update', $this->id),
                ],
                'delete' => [
                    'href' => route('recipes.destroy', $this->id),
                ],
            ],
        ];
    }
}
