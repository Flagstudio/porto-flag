<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class ConfigurationGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:config';

    protected $description = 'Create a Configuration file for a Container';

    protected string $fileType = '';

    protected string $pathStructure = '{container-name}/Configs/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'config.stub';

    public array $inputs = [];

    public function getUserInputs(): array
    {
        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return Str::lower($this->containerName);
    }
}
