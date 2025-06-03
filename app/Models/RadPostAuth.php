<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadPostAuth extends Model
{
    protected $table = 'radpostauth';

    protected $fillable = [
        'username',
        'pass',
        'reply',
        'authdate',
        'class',
    ];

    public $timestamps = false;
}
