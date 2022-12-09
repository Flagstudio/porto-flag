<?php

namespace App\Ship\Captain\Console\Commands;

use App\Ship\Captain\Console\GeneratorCommand;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MigrationGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:migration';

    protected $description = 'Create an "empty" migration file for a Container';

    protected string $fileType = '';

    protected string $pathStructure = '{container-name}/Data/Migrations/*';

    protected string $nameStructure = '{date}_{file-name}';

    protected string $stubName = 'migrations/generic.stub';

    public array $inputs = [
        ['tablename', null, InputOption::VALUE_NONE, 'The name for the database table'],
    ];

    public function getUserInputs(): array
    {
        list($stub, $tableName, $column) = $this->parseMigrationName();

        if (! $tableName) {
            $tableName = Str::lower(
                $this->checkParameterOrAsk('tablename', 'Enter the name of the database table')
            );
        }

        $this->stubName = 'migrations/' . $stub . '.stub';

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => Str::studly($this->fileName),
                'table-name' => $tableName,
                'column-name' => $column,
            ],
            'file-parameters' => [
                'date' => Carbon::now()->format('Y_m_d_His'),
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'Create' . $this->containerName . 'Table';
    }

    protected function removeSpecialChars($str): string
    {
        return $str;
    }

    private function parseMigrationName(): array
    {
        $command = 'Create';
        if (Str::startsWith($this->fileName, $command) && Str::endsWith($this->fileName, 'Table')) {
            $clean = Str::snake(Str::remove([$command, 'Table'], $this->fileName));

            return [
                Str::kebab($command),
                Str::plural($clean),
                '',
            ];
        }

        $command = 'DropColumns';
        if (Str::startsWith($this->fileName, $command)) {
            $clean = Str::snake(Str::remove([$command], $this->fileName));

            return [
                Str::kebab($command),
                Str::plural(Str::after($clean, 'from_')),
                '',
            ];
        }

        $command = 'DropColumn';
        if (Str::startsWith($this->fileName, $command)) {
            $clean = Str::snake(Str::remove([$command], $this->fileName));

            return [
                Str::kebab($command),
                Str::plural(Str::after($clean, 'from_')),
                Str::before($clean, '_from'),
            ];
        }

        $command = 'AddColumn';
        if (Str::startsWith($this->fileName, $command)) {
            $clean = Str::snake(Str::remove([$command], $this->fileName));

            return [
                Str::kebab($command),
                Str::plural(Str::after($clean, 'to_')),
                Str::before($clean, '_to'),
            ];
        }

        return [
            'update',
            '',
            '',
        ];
    }
}
