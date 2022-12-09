<?php

namespace App\Ship\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class PhoneRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Str::match('/^\+79[0-9]{9}$/', $value);
    }

    public function message(): string
    {
        return 'Неверный формат телефона.';
    }
}
