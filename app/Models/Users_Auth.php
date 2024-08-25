<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class Users_Auth extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $collection = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        "user",
        "email",
        "type",

        // hidden
        "password"
    ];

    /**
     * The attributes that are hiden.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password"];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user' => $this->user,
            'type' => $this->type,
        ];
    }
}
