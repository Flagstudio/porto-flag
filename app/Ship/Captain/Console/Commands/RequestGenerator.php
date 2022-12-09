<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class RequestGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:request';

    protected $description = 'Create a new Request class';

    protected string $fileType = 'Request';

    protected string $pathStructure = '{container-name}/Http/Requests/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'request.stub';

    public array $inputs = [
        ['transporter', null, InputOption::VALUE_OPTIONAL, 'Create a corresponding Transporter for this Request'],
        ['transportername', null, InputOption::VALUE_OPTIONAL, 'The name of the Transporter to be assigned'],
    ];

    public function getUserInputs(): array
    {
        $transporterName = Str::replaceLast($this->fileType, '', $this->fileName);
        $transporterName = Str::finish($transporterName, 'Transporter');

        // create the Transporter
        $this->call('flag:transporter', [
            '--container' => $this->containerName,
            '--file' => $transporterName,
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
                'transporter-name' => $transporterName,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
