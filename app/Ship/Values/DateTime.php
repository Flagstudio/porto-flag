<?php

namespace App\Ship\Values;

use Carbon\Carbon;

class DateTime
{
    public function __construct(
        private Carbon $dateTime,
    ) {
    }

    public function getDate(): string
    {
        return $this->dateTime->toDateString();
    }

    public function getTime(): string
    {
        return $this->dateTime->toTimeString();
    }

    public function getValue(): Carbon
    {
        return $this->dateTime;
    }
}
