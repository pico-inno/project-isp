<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

       protected $table = 'batches';

       protected $fillable = [
           'batch_name',
           'batch_description',
           'hotspot_id',
           'batch_status',
       ];


       public function radcheckAccounts()
       {
           return $this->belongsToMany(RadCheck::class, 'batch_radcheck', 'batch_id', 'radcheck_id');
       }
}
