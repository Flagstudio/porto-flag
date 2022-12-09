<?php

namespace App\Ship\Captain\Loaders;

use App\Ship\Captain\Abstracts\Loaders\Loader;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class RoutesLoader extends Loader
{
    public function load(string $containerPath): void
    {
        $this->loadApiContainerRoutes($containerPath);

        $this->loadWebContainerRoutes($containerPath);
    }

    public function loadApiContainerRoutes(string $containerPath): void
    {
        // build the container api routes path
        $apiRoutesPath = $containerPath . '/Routes';
        $apiRoutesFile = $apiRoutesPath . '/api.php';

        if (File::isDirectory($apiRoutesPath) && File::exists($apiRoutesFile)) {
            Route::prefix('api')
                ->name('api.')
                ->middleware('api')
                ->group($apiRoutesFile);
        }
    }

    public function loadWebContainerRoutes(string $containerPath): void
    {
        // build the container web routes path
        $webRoutesPath = $containerPath . '/Routes';
        $webRoutesFile = $webRoutesPath . '/web.php';

        if (File::isDirectory($webRoutesPath) && File::exists($webRoutesFile)) {
            Route::middleware('web')
                ->group($webRoutesFile);
        }
    }
}
