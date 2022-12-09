<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class SubActionGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:subaction';

    protected $description = 'Create a SubAction file for a Container';

    protected string $fileType = 'SubAction';

    protected string $pathStructure = '{container-name}/Actions/SubAction/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'subactions/*.stub';

    public array $inputs = [
        ['stub', null, InputOption::VALUE_OPTIONAL, 'The stub file to load for this generator.'],
    ];

    public function getUserInputs(): array
    {
        $stub = Str::lower(
            $this->checkParameterOrChoice(
                'stub',
                'Select the Stub you want to load',
                ['Generic', 'Action'],
                0
            )
        );

        $this->stubName = Str::replace('*', $stub, $this->stubName);

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
        return 'DefaultAction';
    }
}
