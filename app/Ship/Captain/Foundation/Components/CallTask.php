<?php

namespace App\Ship\Captain\Foundation\Components;

use App\Ship\Parents\Tasks\Task;

class CallTask extends CallComponent
{
    protected function parentInstance($instance): bool
    {
        return $instance instanceof Task;
    }
}
