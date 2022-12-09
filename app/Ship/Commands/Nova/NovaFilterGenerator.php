<?php

namespace App\Ship\Commands\Nova;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class NovaFilterGenerator extends GeneratorCommand implements ComponentsGenerator
{
    public array $inputs = [];

    protected $name = 'nova:filter';

    protected $description = 'Create a new Nova Filter class';

    protected string $fileType = '';

    protected string $pathStructure = '{container-name}/Nova/Filters/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'filter.stub';

    protected function getStubPath(): string
    {
        return 'Commands/Nova/Stubs/' . $this->stubName;
    }

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
