<?php

namespace App\Ship\Captain\Loaders;

use App\Ship\Captain\Abstracts\Loaders\Loader;
use Illuminate\Support\Facades\File;

class CommandsLoader extends Loader
{
    public function load(string $containerPath): ?string
    {
        $commandsPath = "{$containerPath}/Console";

        if (File::isDirectory($commandsPath)) {
            return $commandsPath;
        }

        return null;
    }
}
