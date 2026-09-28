<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Visit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'clinic_id',
        'opened_by',
        'started_at',
        'ended_at',
        'status',
        'chief_complaint',
        'diagnosis',
        'clinical_notes',
        'prescription_notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function openedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(VisitAttachment::class);
    }

    public function medications(): HasMany
    {
        return $this->hasMany(VisitMedication::class);
    }

    public function examination(): HasMany
    {
        return $this->hasMany(Examination::class);
    }

    public function procedures(): HasMany
    {
        return $this->hasMany(MedicalProcedure::class);
    }
}
