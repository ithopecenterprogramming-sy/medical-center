<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    /*
     * Public routes
     */
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login');
    /*
     * Protected routes
     */
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);

    });
});
 
