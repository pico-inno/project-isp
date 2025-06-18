<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchRadcheck extends Model
{
    protected $table = 'batch_radcheck';
    protected $fillable = [
        'batch_id',
        'radcheck_id'
    ];
}
