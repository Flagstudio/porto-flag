<?php

namespace App\Ship\Traits;

trait CanCallSubAction
{
    public function subAction(...$parameters)
    {
        return resolve(\App\Ship\Captain\Foundation\Components\CallSubAction::class)
            ->call(...$parameters);
    }
}
