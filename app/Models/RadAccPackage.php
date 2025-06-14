<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadAccPackage extends Model
{
    protected $fillable = [
        'radcheck_username', 'ppp_profiles_id', 'hotspot_profiles_id',
        'expires_at', 'is_active'
    ];
}
