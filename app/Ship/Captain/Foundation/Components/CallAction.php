<?php

namespace App\Ship\Captain\Foundation\Components;

use App\Ship\Captain\Abstracts\Actions\Action;

class CallAction extends CallComponent
{
    protected function parentInstance($instance): bool
    {
        return $instance instanceof Action;
    }
}
