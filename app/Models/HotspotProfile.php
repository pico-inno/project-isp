<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotspotProfile extends Model
{
    protected $table = 'hotspot_profiles';

    protected $fillable = [
        'name',
        'address_pool',
        'idle_timeout',
        'keepalive_timeout',
        'status_autorefresh',
        'shared_users',
        'rate_limit',
        'mac_cookie',
        'http_cookie',
        'session_timeout',
    ];
}
