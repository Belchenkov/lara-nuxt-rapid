<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Admin
Route::prefix('admin')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

// Ambassador

// Checkout
