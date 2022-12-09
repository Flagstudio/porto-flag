<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ModelGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:model';

    protected $description = 'Create a new Model class';

    protected string $fileType = '';

    protected string $pathStructure = '{container-name}/Domain/Models/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'model.stub';

    public array $inputs = [
        ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the domain'],
        ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the domain'],
        ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the domain'],
    ];

    public function getUserInputs(): array
    {
        $this->warn('Generating Repository class');
        $this->call('flag:repository', [
            '--container' => $this->containerName,
            '--file' => Str::finish($this->fileName, 'Repository'),
            '--section' => $this->sectionName,
        ]);

//        $tableName = Str::plural(Str::snake($this->fileName));

//        $this->warn('Generating Migration file');
//        $this->call('flag:migration', [
//            '--container' => $this->containerName,
//            '--file' => 'create_' . $tableName . '_table',
//            '--tablename' => $tableName,
//            '--stub' => 'create',
//        ]);

        $this->warn('Generating Factory');
        $this->call('flag:factory', [
            '--container' => $this->containerName,
            '--file' => $this->fileName . 'Factory',
            '--model' => $this->fileName,
            '--section' => $this->sectionName,
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
