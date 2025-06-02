<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::updated(function ($user) {
            if ($user->isDirty('role_id')) {
                $user->clearPermissionCache();
            }
        });
    }

    public function cachedPermissions()
    {
        $cacheKey = "user_{$this->id}_permissions";
        $cacheDuration = now()->addDay();

        return Cache::remember($cacheKey, $cacheDuration, function() {
            return $this->role->permissions()
                ->with('feature')
                ->get()
                ->mapToGroups(function ($permission) {
                    return [
                        $permission->feature->name => $permission->name
                    ];
                });
        });
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->role->permissions();
    }

    public function hasPermissionTo($permissionName, $featureName = null)
    {
        $permissions = $this->cachedPermissions();

        if ($featureName) {
            return isset($permissions[$featureName]) &&
                in_array($permissionName, $permissions[$featureName]->toArray());
        }

        return $permissions->flatten()->contains($permissionName);
    }

    public function clearPermissionCache()
    {
        Cache::forget("user_{$this->id}_permissions");
    }

}
