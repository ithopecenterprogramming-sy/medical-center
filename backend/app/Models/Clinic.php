<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\Auditable;
class Clinic extends Model
{
    use SoftDeletes,Auditable;

    protected $fillable = [
        'department_id',
        'name',
        'room_number',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function doctorClinics(): HasMany
    {
        return $this->hasMany(DoctorClinic::class);
    }

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'doctor_clinics',
            'clinic_id',
            'doctor_id'
        )->withPivot('is_primary')->withTimestamps();
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
