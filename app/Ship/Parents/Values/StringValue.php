<?php

namespace App\Ship\Parents\Values;

use App\Ship\Captain\Abstracts\Values\Value as AbstractValue;

abstract class StringValue extends AbstractValue
{
    public function __construct(
        protected string $value,
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
