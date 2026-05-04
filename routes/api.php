<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

// Auth routes (public)
Route::prefix('auth')->middleware('throttle:60,1')->group(function () {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
});

// Protected routes (JWT required)
Route::middleware(['auth:api', 'throttle:60,1'])->group(function () {
  Route::post('auth/logout', [AuthController::class, 'logout']);
  Route::get('auth/me', [AuthController::class, 'me']);

  Route::apiResource('users', UserController::class)->names('api.users');
});
