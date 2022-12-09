<?php

namespace App\Ship\Parents\Actions;

use App\Ship\Captain\Abstracts\Actions\Action as AbstractAction;
use App\Ship\Traits\CanCallCommand;
use App\Ship\Traits\CanCallSubAction;
use App\Ship\Traits\CanCallTask;

abstract class WebAction extends AbstractAction
{
    use CanCallSubAction;
    use CanCallTask;
    use CanCallCommand;
}
