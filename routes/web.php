<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/api/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/api/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('welcome');
});
