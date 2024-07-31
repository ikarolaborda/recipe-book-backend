<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('recipes', \App\Http\Controllers\Api\v1\RecipeController::class);
