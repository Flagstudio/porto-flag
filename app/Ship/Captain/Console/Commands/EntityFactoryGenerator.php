<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class EntityFactoryGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:entity:factory';

    protected $description = 'Create a new Factory for Entity';

    protected string $fileType = 'Factory';

    protected string $pathStructure = '{container-name}/Domain/Factories/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'entity.factory.stub';

    public array $inputs = [
        ['entity', null, InputOption::VALUE_OPTIONAL, 'The name of Entities'],
    ];

    public function getUserInputs(): array
    {
        $entity = Str::remove($this->fileType, $this->fileName);

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'entity' => $entity,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
