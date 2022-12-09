<?php

namespace App\Ship\Captain\Loaders;

use App\Ship\Captain\Abstracts\Loaders\Loader;
use Illuminate\Support\Facades\File;

class ConfigsLoader extends Loader
{
    public function load(string $containerPath): void
    {
        $directory = "{$containerPath}/Configs/";

        if (! File::isDirectory($directory)) {
            return;
        }

        $files = File::allFiles($directory);

        foreach ($files as $file) {
            $fileNameOnly = str_replace('.php', '', $file->getFilename());

            $this->mergeConfigFrom($file->getPathname(), $fileNameOnly);
        }
    }
}
