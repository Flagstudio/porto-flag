<?php

namespace App\Ship\Nova\Actions;

use App\Ship\Traits\CanCallAction;
use Laravel\Nova\Actions\Action;

class BaseAction extends Action
{
    use CanCallAction;
}
