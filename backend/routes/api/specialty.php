<?php
use App\Http\Controllers\Admin\SpecialtyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role.admin'])->prefix('admin')->group(function () {
    
    // مسار استعادة عنصر محذوف
    Route::post('specialties/{id}/restore', [SpecialtyController::class, 'restore']);
    
    // مسارات CRUD المباشرة
    Route::apiResource('specialties', SpecialtyController::class);
    Route::delete('specialties/{id}/force', [SpecialtyController::class, 'forceDelete']);
});