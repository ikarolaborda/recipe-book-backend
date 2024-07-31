<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\RecipeStoreRequest;
use App\Http\Requests\Api\v1\RecipeUpdateRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Services\RecipeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{

    public function __construct(
        protected RecipeService $recipeService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return new JsonResponse(
          RecipeResource::collection(
            $this->recipeService->all(),

          ), Response::HTTP_OK
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(RecipeStoreRequest $request): JsonResponse
    {

        if (!$request->validated() ) {
            return new JsonResponse(
              [
                'message' => 'The given data was invalid.',
              ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $recipe = $this->recipeService->create($validated);

        return new JsonResponse(
          new RecipeResource($recipe), Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe): JsonResponse
    {
        return new JsonResponse(
          new RecipeResource($recipe), Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RecipeUpdateRequest $request, Recipe $recipe): JsonResponse
    {
        if (!$request->validated() ) {
            return new JsonResponse(
              [
                'message' => 'The given data was invalid.',
              ], Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $recipe = $this->recipeService->update($validated, $recipe->id);

        return new JsonResponse(
          new RecipeResource($recipe), Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe): JsonResponse
    {
        $this->recipeService->delete($recipe->id);

        return new JsonResponse(
          null, Response::HTTP_NO_CONTENT
        );
    }
}
