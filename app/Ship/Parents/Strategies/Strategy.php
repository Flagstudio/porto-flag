<?php

namespace App\Ship\Parents\Strategies;

use App\Ship\Traits\CanCallCommand;
use App\Ship\Traits\CanCallTask;

abstract class Strategy
{
    use CanCallTask;
    use CanCallCommand;
}
