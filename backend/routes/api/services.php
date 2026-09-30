<?php
use App\Http\Controllers\Admin\ServiceController;

Route::prefix('admin')->group(function () {
    Route::apiResource('services', ServiceController::class);
    Route::delete('services/{id}/force', [ServiceController::class, 'forceDelete']);
    Route::post('services/{id}/restore', [ServiceController::class, 'restore']);
});