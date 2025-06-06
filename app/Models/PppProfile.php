<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PppProfile extends Model
{
    protected $fillable = [
        'name', 'download_speed',
        'upload_speed', 'price', 'validity_days', 'mikrotik_profile'
    ];
}
