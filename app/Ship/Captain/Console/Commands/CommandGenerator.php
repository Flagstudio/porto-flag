<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class CommandGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:console:command';

    protected $description = 'Create a Console Command file for a Container';

    protected string $fileType = 'Command';

    protected string $pathStructure = '{container-name}/Console/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'command.stub';

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
        return 'Command';
    }
}
