<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RolePermission extends Pivot
{
    protected $table = 'role_permissions';

    protected $fillable = ['role_id', 'permission_id'];

    public static function booted()
    {
        static::created(function ($rolePermission) {
            User::where('role_id', $rolePermission->role_id)
                ->each(fn($user) => $user->clearPermissionCache());
        });

        static::deleted(function ($rolePermission) {
            User::where('role_id', $rolePermission->role_id)
                ->each(fn($user) => $user->clearPermissionCache());
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
