<?php

namespace App\Ship\Parents\Tasks;

use App\Ship\Captain\Abstracts\Tasks\Task as AbstractTask;
use App\Ship\Traits\CanCallCommand;

abstract class Task extends AbstractTask
{
    use CanCallCommand;
}
