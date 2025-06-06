<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadAccPackage extends Model
{
    protected $fillable = [
        'radcheck_id', 'ppp_profiles_id',
        'expires_at', 'is_active'
    ];
}
