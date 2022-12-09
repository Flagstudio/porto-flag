<?php

namespace App\Containers\Client\Domain\Models;

use App\Containers\Client\Domain\Properties\Enums\RolesEnum;
use App\Containers\FaceControl\Domain\Models\PersonalVerificationCode;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends UserModel
{
    use HasApiTokens;

    protected $dates = [
        'birthday',
        'phone_verified_at',
    ];

    public function verificationCode(): HasMany
    {
        return $this->hasMany(PersonalVerificationCode::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === RolesEnum::ADMIN->value;
    }

    public function isEditor(): bool
    {
        return $this->role === RolesEnum::EDITOR->value;
    }
}
