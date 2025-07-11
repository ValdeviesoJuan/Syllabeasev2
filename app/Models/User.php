<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\roles;

class User extends Authenticatable  implements Auditable
//  implements MustVerifyEmail
{
    use \OwenIt\Auditing\Auditable; 
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'phone',
        'email',
        'prefix',
        'suffix',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];    

    public function roles()
    {
        return $this->hasManyThrough(
            \App\Models\Roles::class,        // Final model you want
            \App\Models\UserRole::class,     // Intermediate model
            'user_id',                       // Foreign key on UserRole
            'role_id',                       // Foreign key on Role
            'id',                            // Local key on User
            'role_id'                        // Local key on UserRole
        );
    }
    public function userRoles()
    {
        return $this->hasMany(\App\Models\UserRole::class, 'user_id');
    }

    public function bayanihanGroupUsers()
    {
        return $this->hasMany(BayanihanGroupUsers::class);
    }
}
