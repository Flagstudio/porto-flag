<?php

namespace App\Ship\Captain\Abstracts\Events\Traits;

trait JobProperties
{
    public \DateTimeInterface|\DateInterval|int|null $jobDelay;

    public string $jobQueue;
}
