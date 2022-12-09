<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class ViewModelGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:view-model';

    protected $description = 'Create a View Model file for a Container';

    protected string $fileType = 'ViewModel';

    protected string $pathStructure = '{container-name}/ViewModels/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'view-model.stub';

    public array $inputs = [

    ];

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
        return 'DefaultViewModel';
    }
}
