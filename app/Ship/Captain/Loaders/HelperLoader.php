<?php

namespace App\Ship\Captain\Loaders;

use App\Ship\Captain\Abstracts\Loaders\Loader;
use Illuminate\Support\Facades\File;

class HelperLoader extends Loader
{
    public function load(string $containerPath): void
    {
        $helpersPath = $containerPath . '/Helpers/';

        if (File::isDirectory($helpersPath)) {
            $helpers = File::allFiles($helpersPath);

            foreach ($helpers as $helper) {
                require_once $helper->getRealPath();
            }
        }
    }
}
