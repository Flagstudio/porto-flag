<?php

namespace App\Containers\Client\Domain\Properties\Values;

use Carbon\Carbon;

class BirthdayValue
{
    public function __construct(
        private Carbon $date,
    ) {
    }

    public function __toString(): string
    {
        return $this->date->format('Y-m-d');
    }
}
