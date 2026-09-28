<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitMedication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'visit_id',
        'medication_id',
        'dose',
        'frequency',
        'duration',
        'instructions',
        'is_previous',
    ];

    protected $casts = [
        'is_previous' => 'boolean',
    ];

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    public function medication(): BelongsTo
    {
        return $this->belongsTo(Medication::class);
    }
}
