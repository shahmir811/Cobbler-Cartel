<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }    

    public function getJWTCustomClaims()
    {
        return [];
    }    

    public function hasRole($role)
    {
        if ($this->role->name == $role) {
        return true;
        }


        return false;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            $name = strtolower($user->name);
            $name = preg_replace('/\s+/', '-', $name);
            $user->slug = strtolower($name) . '-' . time();
        });
    }    

}
