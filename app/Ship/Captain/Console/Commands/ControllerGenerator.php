<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ControllerGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:controller';

    protected $description = 'Create a controller for a container';

    protected string $fileType = 'Controller';

    protected string $pathStructure = '{container-name}/Http/Controllers/{ui}/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'controllers/generic.stub';

    public array $inputs = [
        ['api', 'a', InputOption::VALUE_NONE, 'The user-interface to generate the Controller for.'],
        ['stub', null, InputOption::VALUE_OPTIONAL, 'The stub file to load for this generator.'],
        ['requests', 'R', InputOption::VALUE_OPTIONAL, 'Generate the corresponding Controller for this Model?'],
        ['model', 'm', InputOption::VALUE_OPTIONAL, 'The Model for generate Requests for Controller.'],
    ];

    public function getUserInputs(): array
    {
        $stub = Str::lower(
            $this->checkParameterOrChoice(
                'stub',
                'Select the Stub you want to load',
                ['Generic', 'Invoke', 'Resource'],
                0
            )
        );

        if ($stub == 'resource') {
            $requests = $this->checkParameterOrConfirm(
                'requests',
                'Do you want to generate the corresponding Requests for this Controller?',
                true
            );

            if ($requests) {
                $model = $this->checkParameterOrAsk('model', 'Enter the name of the Model file');
                $arrRequests = [
                    'store' => "Store{$model}Request",
                    'update' => "Update{$model}Request",
                ];

                $stub = 'resource.requests';

                foreach ($arrRequests as $request) {
                    $status = $this->call('flag:request', [
                        '--container' => $this->containerName,
                        '--file' => $request,
                    ]);

                    if ($status == 0) {
                        $this->printInfoMessage('The Request was successfully generated');
                    } else {
                        $this->printErrorMessage('Could not generate the corresponding Request!');
                    }
                }
            }
        }

        // load a new stub-file based on the users choice
        $this->stubName = 'controllers/' . $stub . '.stub';

        $isApi = $this->option('api');
        $ui = $isApi ? 'Api' : 'Web';

        $parentController = sprintf(
            '%sController',
            $ui
        );

        $this->pathStructure = Str::replaceLast('{ui}', $ui, $this->pathStructure);

        // name of the model (singular and plural)
        $model = $this->containerName;
        $models = Pluralizer::plural($model);

        $entity = Str::lower($model);
        $entities = Pluralizer::plural($entity);

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'base-controller' => $parentController,
                'ui' => $ui,

                'model' => $model,
                'models' => $models,
                'entity' => $entity,
                'entities' => $entities,
                'store-request' => $arrRequests['store'] ?? '',
                'update-request' => $arrRequests['update'] ?? '',
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'Controller';
    }
}
