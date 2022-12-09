<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class DomainCommandGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:domain:command';

    protected $description = 'Create a Command for the domain';

    protected string $fileType = 'Command';

    protected string $pathStructure = '{container-name}/Domain/Commands/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'domain.command.stub';

    public array $inputs = [];

    public function getUserInputs(): array
    {
        $entity = Str::remove($this->fileType, $this->fileName);
        $entity = Str::remove(['Create', 'Update', 'Delete'], $entity);

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'entity-name' => $entity,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'Command';
    }
}
