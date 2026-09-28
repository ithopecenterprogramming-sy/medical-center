<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'generic_name',
        'strength',
        'form',
        'unit',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function visitMedications(): HasMany
    {
        return $this->hasMany(VisitMedication::class);
    }
}
