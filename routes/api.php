<?php

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
