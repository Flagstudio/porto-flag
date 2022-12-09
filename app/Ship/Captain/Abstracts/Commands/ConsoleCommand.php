<?php

namespace App\Ship\Captain\Abstracts\Commands;

use App\Ship\Traits\CanCallAction;
use Illuminate\Console\Command as LaravelCommand;

abstract class ConsoleCommand extends LaravelCommand
{
    use CanCallAction;
}
