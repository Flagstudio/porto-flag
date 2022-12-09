<?php

namespace App\Ship\Parents\Values;

use App\Ship\Captain\Abstracts\Values\Value as AbstractValue;
use Carbon\Carbon;

abstract class DateValue extends AbstractValue
{
    public function __construct(
        private Carbon|string $date,
    ) {
        if (is_string($date)) {
            $this->date = Carbon::parse($date);
        }
    }

    public function __toString(): string
    {
        return $this->date->toDateString();
    }

    public function getValue(): Carbon
    {
        return $this->date;
    }
}
