<?php

namespace App\Ship\Traits;

trait CanCallCommand
{
    public function command(...$parameters)
    {
        return resolve(\App\Ship\Captain\Foundation\Components\CallCommand::class)
            ->call(...$parameters);
    }
}
