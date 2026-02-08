<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes - Google OAuth Only
|--------------------------------------------------------------------------
*/

// Guest routes (belum login)
Route::middleware('guest')->group(function () {
    // Register page (untuk user baru)
    Route::get('register', [GoogleAuthController::class, 'showRegister'])
        ->name('register');

    // Login page (untuk user existing)
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Google OAuth - Single callback for both register and login
    Route::get('auth/google/register', [GoogleAuthController::class, 'redirectRegister'])
        ->name('auth.google.register');
    Route::get('auth/google', [GoogleAuthController::class, 'redirect'])
        ->name('auth.google');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])
        ->name('auth.google.callback');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Complete Profile (untuk user baru via Google)
    Route::get('complete-profile', [GoogleAuthController::class, 'showCompleteProfile'])
        ->name('complete-profile');
    Route::post('complete-profile', [GoogleAuthController::class, 'storeCompleteProfile'])
        ->name('complete-profile.store');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
