<?php

namespace App\Ship\Captain\Console\Traits;

use Exception;

trait FileSystemTrait
{
    protected function alreadyExists(string $path): bool
    {
        return $this->fileSystem->exists($path);
    }

    public function generateFile(string $filePath, $stubContent)
    {
        return $this->fileSystem->put($filePath, $stubContent);
    }

    public function createDirectory(string $path)
    {
        if ($this->alreadyExists($path)) {
            $this->printErrorMessage($this->fileType . ' already exists');

            // the file does exist - return but NOT exit
            return;
        }

        try {
            if (! $this->fileSystem->isDirectory(dirname($path))) {
                $this->fileSystem->makeDirectory(dirname($path), 0777, true, true);
            }
        } catch (Exception $e) {
            $this->printErrorMessage('Could not create ' . $path);
        }
    }
}
