<?php

namespace App\Ship\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class PasswordRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Str::match('/[A-Z]/', $value)
            && Str::match('/\d/', $value)
            && mb_strlen($value) >= 6
            && mb_strlen($value) <= 16;
    }

    public function message(): string
    {
        return 'Неверный формат пароля.';
    }
}
