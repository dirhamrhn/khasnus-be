<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\FoodController;
// use App\Http\Controllers\Api\AuthController;

// Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
// Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/foods', [FoodController::class, 'index']);
Route::get('/foods/search', [FoodController::class, 'search']);
Route::get('/foods/{id}', [FoodController::class, 'show']);

Route::get('/provinces', [ProvinceController::class, 'index']);
Route::get('/provinces/search', [ProvinceController::class, 'search']);
Route::get('/provinces/{id}', [ProvinceController::class, 'show']);
Route::get('/provinces/{id}/foods', [FoodController::class, 'byProvince']);