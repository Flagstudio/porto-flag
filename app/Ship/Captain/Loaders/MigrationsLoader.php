<?php

namespace App\Ship\Captain\Loaders;

use App\Ship\Captain\Abstracts\Loaders\Loader;
use Illuminate\Support\Facades\File;

class MigrationsLoader extends Loader
{
    public function load(string $containerPath): void
    {
        $migrationsPath = $containerPath . '/Data/Migrations/';

        if (File::isDirectory($migrationsPath)) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }
}
