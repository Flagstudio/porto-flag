<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class DomainExceptionGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:domain:exception';

    protected $description = 'Create a new Exception for the domain';

    protected string $fileType = 'Exception';

    protected string $pathStructure = '{container-name}/Domain/Exceptions/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'domain.exception.stub';

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
}
