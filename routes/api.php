<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FavoriteController;

// public Auth Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// public Food Routes
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/foods/search', [FoodController::class, 'search']);
Route::get('/foods/top', [FoodController::class, 'topFoods']);
Route::get('/foods/{id}', [FoodController::class, 'show']);

// public Province Routes
Route::get('/provinces', [ProvinceController::class, 'index']);
Route::get('/provinces/search', [ProvinceController::class, 'search']);
Route::get('/provinces/{id}', [ProvinceController::class, 'show']);
Route::get('/provinces/{id}/foods', [FoodController::class, 'byProvince']);

// Protected Routes (Requires Auth)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Favorite Routes
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);

    // Admin Routes (Requires Auth + Admin Role)
    Route::middleware('admin')->prefix('admin')->group(function () {
        // Admin Province CRUD
        Route::get('/provinces', [\App\Http\Controllers\Admin\ProvinceController::class, 'index']);
        Route::post('/provinces', [\App\Http\Controllers\Admin\ProvinceController::class, 'store']);
        Route::get('/provinces/{id}', [\App\Http\Controllers\Admin\ProvinceController::class, 'show']);
        Route::put('/provinces/{id}', [\App\Http\Controllers\Admin\ProvinceController::class, 'update']);
        Route::delete('/provinces/{id}', [\App\Http\Controllers\Admin\ProvinceController::class, 'destroy']);

        // Admin Food CRUD
        Route::get('/foods', [\App\Http\Controllers\Admin\FoodController::class, 'index']);
        Route::post('/foods', [\App\Http\Controllers\Admin\FoodController::class, 'store']);
        Route::get('/foods/{id}', [\App\Http\Controllers\Admin\FoodController::class, 'show']);
        Route::put('/foods/{id}', [\App\Http\Controllers\Admin\FoodController::class, 'update']);
        Route::delete('/foods/{id}', [\App\Http\Controllers\Admin\FoodController::class, 'destroy']);

        // Admin Image Upload helper
        Route::post('/upload', [\App\Http\Controllers\Admin\UploadController::class, 'uploadImage']);
    });
});