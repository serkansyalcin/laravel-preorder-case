<?php

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;


Route::get('me', [AuthController::class, 'info'])->middleware('auth:sanctum');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// User
Route::prefix('user')->group(function () {
    Route::get('login', [AuthController::class, 'userLogin'])->name('login');
})->name('user.*');

// Admin
Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'adminLogin'])->middleware(HandlePrecognitiveRequests::class);

    Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {
        Route::get('check', function () {
            return response()->json(['message' => 'ADMIN - ABILITIY | PASSED']);
        });
    });
});
