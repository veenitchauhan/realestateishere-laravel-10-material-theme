<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'location',
        'phone',
        'about',
        'password_confirmation'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically assign Dealer role to new users
        static::created(function ($user) {
            $user->assignRole('Dealer');
        });
    }
    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Override to give Super Admin all permissions automatically
     */
    public function getAllPermissions(): \Illuminate\Support\Collection
    {
        // Super Admin gets all permissions automatically
        if ($this->hasRole('Super Admin')) {
            return \Spatie\Permission\Models\Permission::all();
        }

        // Call the original implementation from the trait
        $permissions = $this->permissions;
        $permissions = $permissions->merge($this->getPermissionsViaRoles());
        return $permissions->sort()->values();
    }

    /**
     * Get all properties created by this user
     */
    public function properties()
    {
        return $this->hasMany(Property::class, 'added_by');
    }

}
