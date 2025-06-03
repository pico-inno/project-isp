<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NasReload extends Model
{
    protected $table = 'nasreload';

    protected $primaryKey = 'nasipaddress';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nasipaddress',
        'reloadtime',
    ];

    public $timestamps = false;
}
