<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class TransporterGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:transporter';

    protected $description = 'Create a new Transporter class';

    protected string $fileType = 'Transporter';

    protected string $pathStructure = '{container-name}/Transfers/Transporters/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'transporter.stub';

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
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
