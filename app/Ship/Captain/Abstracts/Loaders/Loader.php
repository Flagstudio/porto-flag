<?php

namespace App\Ship\Captain\Abstracts\Loaders;

use Illuminate\Support\ServiceProvider;

abstract class Loader extends ServiceProvider
{
    public function __construct()
    {
        parent::__construct(App());
    }

    abstract public function load(string $containerPath);
}
