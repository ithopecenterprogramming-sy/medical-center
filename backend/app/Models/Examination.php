<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Examination extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'examination_type_id',
        'patient_id',
        'doctor_id',
        'visit_id',
        'service_id',
        'status',
        'performed_at',
        'result',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ExaminationType::class, 'examination_type_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
