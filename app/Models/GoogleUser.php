<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class GoogleUser extends Authenticatable implements JWTSubject
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users_google';

    protected $fillable = [
        'name',
        'email',
        'image',
        'lastName',
        'role',
        'googleId',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            "email" => $this->email,
            "name" => $this->name,
            "lastName" => $this->lastName,
            "role" => $this->role,

        ];
    }

}
