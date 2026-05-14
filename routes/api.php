<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\FoodController;

Route::get('/foods', [FoodController::class, 'index']);
Route::get('/foods/search', [FoodController::class, 'search']);
Route::get('/foods/{id}', [FoodController::class, 'show']);

Route::get('/provinces', [ProvinceController::class, 'index']);
Route::get('/provinces/search', [ProvinceController::class, 'search']);
Route::get('/provinces/{id}', [ProvinceController::class, 'show']);
Route::get('/provinces/{id}/foods', [FoodController::class, 'byProvince']);