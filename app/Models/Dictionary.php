<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'attribute',
        'value',
        'format',
        'vendor',
        'recommended_OP',
        'recommended_table',
        'recommended_helper',
        'recommended_tooltip',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
