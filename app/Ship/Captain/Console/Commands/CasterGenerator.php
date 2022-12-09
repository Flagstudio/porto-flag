<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class CasterGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:caster';

    protected $description = 'Create a new Collection class';

    protected string $fileType = 'Caster';

    protected string $pathStructure = '{container-name}/Transfers/Transporters/Casters/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'caster.stub';

    public array $inputs = [
        ['collection', 'c', InputOption::VALUE_NONE],
        ['item', 'i', InputOption::VALUE_NONE],
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
                'collection-name' => $this->option('collection'),
                'item-name' => $this->option('item'),
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
