<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class CollectionItemGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:collection:item';

    protected $description = 'Create a new Item Collection class';

    protected string $fileType = 'Item';

    protected string $pathStructure = '{container-name}/Domain/Properties/Collections/Items/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'collection.item.stub';

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
