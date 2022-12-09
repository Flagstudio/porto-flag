<?php

namespace App\Ship\Parents\Models;

use App\Ship\Captain\Abstracts\Models\UserModel as AbstractUserEntity;
use Illuminate\Notifications\Notifiable;

abstract class UserModel extends AbstractUserEntity
{
    use Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        return [];
    }
}
