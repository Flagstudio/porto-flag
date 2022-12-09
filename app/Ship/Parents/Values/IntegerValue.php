<?php

namespace App\Ship\Parents\Values;

use App\Ship\Captain\Abstracts\Values\Value as AbstractValue;

abstract class IntegerValue extends AbstractValue
{
    public function __construct(
        private int $value,
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
