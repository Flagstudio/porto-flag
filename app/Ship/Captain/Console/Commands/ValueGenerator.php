<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class ValueGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:value';

    protected $description = 'Create a new Value class';

    protected string $fileType = '';

    protected string $pathStructure = '{container-name}/Domain/Properties/Values/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'value.stub';

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
                'resource-key' => strtolower(Pluralizer::plural($this->fileName)),
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
