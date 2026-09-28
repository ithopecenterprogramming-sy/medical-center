<?php
use App\Http\Controllers\Admin\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role.admin'])->prefix('admin')->group(function () {
    Route::delete('departments/{id}/force', [DepartmentController::class, 'forceDelete']);
    Route::post('departments/{id}/restore', [DepartmentController::class, 'restore']);
    Route::apiResource('departments', DepartmentController::class);
});