<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemCheck extends Model
{
    protected $fillable = [
        'name',
        'category',
        'status',
        'message',
        'details',
        'checked_at',
    ];

    protected $casts = [
        'checked_at' => 'datetime',
    ];
}
