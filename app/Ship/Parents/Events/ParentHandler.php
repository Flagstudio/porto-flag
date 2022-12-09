<?php

namespace App\Ship\Parents\Events;

use App\Ship\Captain\Abstracts\Events\Handler;
use App\Ship\Traits\CanCallAction;
use App\Ship\Traits\CanCallCommand;

abstract class ParentHandler extends Handler
{
    use CanCallAction;
    use CanCallCommand;
}
