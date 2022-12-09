<?php

namespace App\Ship\Captain\Foundation\Components;

use App\Ship\Parents\Actions\SubAction;

class CallSubAction extends CallComponent
{
    protected function parentInstance($instance): bool
    {
        return $instance instanceof SubAction;
    }
}
