<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class CollectionGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:collection';

    protected $description = 'Create a new Collection class';

    protected string $fileType = 'Collection';

    protected string $pathStructure = '{container-name}/Domain/Properties/Collections/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'collection.stub';

    public array $inputs = [];

    public function getUserInputs(): array
    {
        $itemName = Str::remove('Collection', $this->fileName);
        $this->warn('Generating Item');
        $this->call('flag:collection:item', [
            '--container' => $this->containerName,
            '--file' => $itemName,
        ]);

        $this->warn('Generating Caster');
        $this->call('flag:caster', [
            '--container' => $this->containerName,
            '--file' => $itemName,
            '--collection' => $this->fileName,
            '--item' => $itemName . 'Item',
        ]);

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'item-name' => $itemName,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
