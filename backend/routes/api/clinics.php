<?php
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role.admin'])->prefix('admin')->group(function () {
    // --- Clinics ---
    Route::delete('clinics/{id}/force', [ClinicController::class, 'forceDelete']);
    Route::post('clinics/{id}/restore', [ClinicController::class, 'restore']);
    Route::apiResource('clinics', ClinicController::class);

    // --- Departments ---
    Route::delete('departments/{id}/force', [DepartmentController::class, 'forceDelete']);
    Route::post('departments/{id}/restore', [DepartmentController::class, 'restore']);
    Route::apiResource('departments', DepartmentController::class);
});