<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class RepositoryGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:repository';

    protected $description = 'Create a new Repository class';

    protected string $fileType = 'Repository';

    protected string $pathStructure = '{container-name}/Domain/Repositories/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'repository.stub';

    public array $inputs = [
    ];

    public function getUserInputs(): array
    {
        $modelName = Str::remove($this->fileType, $this->fileName);

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'model-name' => $modelName,
                'factory-name' => $modelName . 'Factory',
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
