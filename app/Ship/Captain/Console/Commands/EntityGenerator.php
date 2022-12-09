<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class EntityGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:entity';

    protected $description = 'Create a new Entity class';

    protected string $fileType = 'Entity';

    protected string $pathStructure = '{container-name}/Domain/Entities/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'entity.stub';

    public array $inputs = [];

    public function getUserInputs(): array
    {
        $this->warn('Generating Entity Factory');
        $this->call('flag:entity:factory', [
            '--container' => $this->containerName,
            '--file' => $this->fileName,
            '--entity' => $this->fileName,
        ]);

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

    public function getSelectedOptions(): Collection
    {
        return collect($this->options())
            ->filter(fn ($item): bool => $item === true);
    }
}
