<?php
namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use SoftDeletes, Auditable;

    protected $fillable = [
        'service_type_id',
        'name',
        'description',
        'cost',
        'is_active',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }
}