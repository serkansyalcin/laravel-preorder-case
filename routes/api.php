<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
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

        /*API - User*/
        Route::get('user/list', [UserController::class, 'index'])->name('user.index');
        Route::get('user/single/{id}', [UserController::class, 'show'])->name('user.show');
        Route::post('user/store', [UserController::class, 'store'])->name('user.store');
        Route::post('user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        /*API - Category*/
        //Route::apiResource('category', CategoryController::class);
        Route::get('category/list', [CategoryController::class, 'index'])->name('category.index');
        Route::get('category/single/{id}', [CategoryController::class, 'show'])->name('category.show');
        Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::post('category/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');


        /*API - Product*/
        Route::get('product/list', [ProductController::class, 'index'])->name('product.index');
        Route::get('product/single/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
        Route::post('product/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::post('product/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    });
});


Route::fallback(function () {
    return response()->json([
        'message' => 'Not found'
    ], 404);
});
