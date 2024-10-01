<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get('/check', function () {
    // Returning test response
    return response()->json([
        'status' => 'success',
        'message' => "API Called successfully!",
        'data' => null
    ], Response::HTTP_OK);
});

Route::prefix('user')->group(function () {
    Route::get('login', [AuthController::class, 'userLogin'])->name('login');
})->name('user.*');

Route::prefix('admin')->group(function () {
    // Route::get()
});
