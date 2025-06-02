<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static function booted()
    {
        static::deleted(function ($role) {
            User::where('role_id', $role->id)
                ->each(fn($user) => $user->clearPermissionCache());
        });

        static::updated(function ($role) {
            if ($role->isDirty('name')) {
                User::where('role_id', $role->id)
                    ->each(fn($user) => $user->clearPermissionCache());
            }
        });
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->using(RolePermission::class)
            ->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
