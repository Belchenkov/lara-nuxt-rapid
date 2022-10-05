<?php

use App\Http\Controllers\AmbassadorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Admin
Route::prefix('admin')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::put('users/info', [AuthController::class, 'updateInfo']);
        Route::put('users/password', [AuthController::class, 'updatePassword']);

        Route::get('ambassadors', [AmbassadorController::class, 'index']);

        Route::get('users/{user_id}/links', [LinkController::class, 'index']);

        Route::apiResource('products', ProductController::class);
    });
});

// Ambassador

// Checkout
