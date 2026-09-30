<?php
namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceType extends Model
{
    use SoftDeletes, Auditable;

    protected $fillable = [
        'name',
        'description',
        'cost',
        'is_active',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}