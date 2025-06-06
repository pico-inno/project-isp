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
            'radcheck_id',       // Foreign key on RadAccPackage
            'id',                // Foreign key on PppProfile
            'id',                // Local key on RadCheck
            'ppp_profiles_id'    // Local key on RadAccPackage
        );
    }

}
