<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CtProcedure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'imaging_type_id',
        'created_by',
        'scheduled_at',
        'image_type',
        'has_injection',
        'creatinine',
        'health_problem',
        'imaging_notes',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'has_injection' => 'boolean',
        'creatinine' => 'decimal:3',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function imagingType(): BelongsTo
    {
        return $this->belongsTo(CtImagingType::class, 'imaging_type_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
