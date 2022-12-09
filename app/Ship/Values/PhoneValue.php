<?php

namespace App\Ship\Values;

use App\Containers\Client\Domain\Exceptions\InvalidPhoneNumberException;
use App\Ship\Parents\Values\StringValue;
use Illuminate\Support\Str;

class PhoneValue extends StringValue
{
    public function __construct(
        protected string $value,
    ) {
        Str::match('/^\+79[0-9]{9}$/', $this->value) or throw new InvalidPhoneNumberException();
    }
}
