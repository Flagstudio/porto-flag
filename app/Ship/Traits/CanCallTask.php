<?php

namespace App\Ship\Traits;

trait CanCallTask
{
    public function task(...$parameters)
    {
        return resolve(\App\Ship\Captain\Foundation\Components\CallTask::class)
            ->call(...$parameters);
    }
}
