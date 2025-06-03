<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Router extends Model
{
    protected $table = 'routers';
    protected $fillable = ['name', 'slug', 'host', 'username', 'password', 'port'];

    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'port' => 'integer'
    ];

    protected static function booted()
    {
        static::creating(function ($router) {
            if (empty($router->slug)) {
                $router->slug = Str::slug($router->name);
            }
        });
    }
}
