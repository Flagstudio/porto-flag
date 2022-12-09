<?php

namespace App\Ship\Traits;

trait CanCallAction
{
    public function action(...$parameters)
    {
        return resolve(\App\Ship\Captain\Foundation\Components\CallAction::class)
            ->call(...$parameters);
    }
}
