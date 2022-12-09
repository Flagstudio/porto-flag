<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class DomainGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:domain';

    protected $description = 'Create a new Domain class';

    protected string $fileType = 'Domain';

    protected string $pathStructure = '{container-name}/Domain/Entities/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'entity.stub';

    public array $inputs = [
        ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the domain'],
        ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the domain'],
        ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the domain'],
    ];

    public function handle(): void
    {
        $this->validateGenerator($this);

        $this->containerName = $this->argument('container')
            ?? ucfirst($this->checkParameterOrAsk('container', 'Enter the name of the Container'));
        $this->fileName = $this->containerName = $this->removeSpecialChars($this->containerName);

        $this->warn('Generating configuration file');
        $this->call('flag:config', [
            '--container' => $this->containerName,
            '--file' => Str::lower($this->containerName),
        ]);

        $this->warn('Generating Entity file');
        $this->call('flag:entity', [
            '--container' => $this->containerName,
            '--file' => $this->fileName,
        ]);

        $this->warn('Generating Model file');
        $this->call('flag:model', [
            '--container' => $this->containerName,
            '--file' => $this->fileName,
        ]);

        $this->warn('Generating Routes file');
        $this->call('flag:route', [
            '--container' => $this->containerName,
            '--file' => $this->fileName,
            '--stub' => 'all',
        ]);

        $this->warn('Generating Test');
        $this->call('flag:test', [
            '--container' => $this->containerName,
            '--file' => $this->containerName,
            '--type' => 'Functional',
        ]);
    }

    public function getUserInputs(): array
    {
        return [];
    }

    public function getSelectedOptions(): Collection
    {
        return collect($this->options())
            ->filter(fn ($item): bool => $item === true);
    }
}
