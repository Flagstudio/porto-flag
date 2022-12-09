<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class TransformerGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:transformer';

    protected $description = 'Create a new Transformer class for a given Model';

    protected string $fileType = 'Transformer';

    protected string $pathStructure = '{container-name}/Transfers/Transformers/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'transformer.stub';

    public array $inputs = [
        ['model', null, InputOption::VALUE_OPTIONAL, 'The model to generate this Transformer for'],
        ['full', null, InputOption::VALUE_OPTIONAL, 'Generate a Transformer with all fields of the model'],
    ];

    public function getUserInputs(): array
    {
        $model = $this->checkParameterOrAsk('model', 'Enter the name of the Model to generate this Transformer for');

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'model' => $model,
                'attributes' => [],
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
