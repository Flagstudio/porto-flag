<?php

namespace App\Ship\Captain\Foundation\Facades;

use Illuminate\Support\Facades\Facade;

class Captain extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Captain';
    }
}
