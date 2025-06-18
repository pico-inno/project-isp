<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadCheck extends Model
{
    protected $table = 'radcheck';

    protected $fillable = [
        'username',
        'attribute',
        'op',
        'value',
    ];

    public $timestamps = false;

    public function accPackage()
    {
        return $this->hasOne(RadAccPackage::class, 'radcheck_id');
    }

    public function pppProfile()
    {
        return $this->hasOneThrough(
            PppProfile::class,
            RadAccPackage::class,
            'radcheck_username',       // Foreign key on RadAccPackage
            'id',                // Foreign key on PppProfile
            'id',                // Local key on RadCheck
            'ppp_profiles_id'    // Local key on RadAccPackage
        );
    }

    public function hotspotProfile()
    {
        return $this->hasOneThrough(
            HotspotProfile::class,
            RadAccPackage::class,
            'radcheck_username',       // Foreign key on RadAccPackage
            'id',                // Foreign key on PppProfile
            'id',                // Local key on RadCheck
            'hotspot_profiles_id'    // Local key on RadAccPackage
        );
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_radcheck');
    }

    public function radusergroup()
    {
        return $this->hasOne(RadUserGroup::class, 'username', 'username');
    }

    public function radreply()
    {
        return $this->hasOne(RadReply::class, 'username', 'username');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function radusergroups()
    {
        return $this->hasMany(RadUserGroup::class, 'username', 'username');
    }
}
