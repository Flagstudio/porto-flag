<?php

namespace App\Ship\Captain\Foundation\Components;

use App\Ship\Captain\Abstracts\Responders\AbstractResponder;

class CallResponder extends CallComponent
{
    protected function parentInstance($instance): bool
    {
        return $instance instanceof AbstractResponder;
    }
}
