<?php

namespace App\Ship\Captain\Foundation\Components;

use App\Ship\Parents\Domain\Commands\ParentCommand;

class CallCommand extends CallComponent
{
    protected function parentInstance($instance): bool
    {
        return $instance instanceof ParentCommand;
    }
}
