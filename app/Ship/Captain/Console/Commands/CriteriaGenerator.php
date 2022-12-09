<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class CriteriaGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:criteria';

    protected $description = 'Create a new Criteria class';

    protected string $fileType = 'Criteria';

    protected string $pathStructure = '{container-name}/Domain/Repositories/Criterias/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'criteria.stub';

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
