<?php
use App\Http\Controllers\Admin\ServiceTypeController;

Route::prefix('admin')->group(function () {
    Route::apiResource('service-types', ServiceTypeController::class);
    Route::delete('service-types/{id}/force', [ServiceTypeController::class, 'forceDelete']);
    Route::post('service-types/{id}/restore', [ServiceTypeController::class, 'restore']);
});