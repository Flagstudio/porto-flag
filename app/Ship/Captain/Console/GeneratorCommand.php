<?php

namespace App\Ship\Captain\Console;

use App\Ship\Captain\Console\Exceptions\GeneratorErrorException;
use App\Ship\Captain\Console\Interfaces\ComponentsGenerator;
use App\Ship\Captain\Console\Traits\FileSystemTrait;
use App\Ship\Captain\Console\Traits\FormatterTrait;
use App\Ship\Captain\Console\Traits\ParserTrait;
use App\Ship\Captain\Console\Traits\PrinterTrait;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

abstract class GeneratorCommand extends Command
{
    use ParserTrait;
    use PrinterTrait;
    use FileSystemTrait;
    use FormatterTrait;

    protected const ROOT = 'app';

    protected const STUB_PATH = 'Stubs/*';

    protected const CUSTOM_STUB_PATH = 'Generators/CustomStubs/*';

    protected const CONTAINER_DIRECTORY_NAME = 'Containers';

    protected const SHIP_DIRECTORY_NAME = 'Ship';

    protected string $filePath;

    protected string $containerName;

    protected string $fileName;

    protected string $sectionName = '';

    protected array $userData;

    protected string $parsedFileName;

    protected string $stubContent;

    protected string $renderedStubContent;

    protected Filesystem $fileSystem;

    protected array $defaultInputs = [
        ['container', null, InputOption::VALUE_REQUIRED, 'The name of the container'],
        ['file', null, InputOption::VALUE_REQUIRED, 'The name of the file'],
        ['ship', 's', InputOption::VALUE_NONE, 'Create file in ship layer'],
        ['section', null, InputOption::VALUE_OPTIONAL, 'The name of the section'],
        ['need_section', 'S', InputOption::VALUE_NONE, 'The name of the section'],
    ];

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;

        $this->signature = $this->name . ' {container?} {file?}';

        parent::__construct();

        $this->specifyParameters();
    }

    public function handle()
    {
        $this->validateGenerator($this);

        $this->containerName = $this->argument('container')
            ?? $this->checkParameterOrAsk('container', 'Enter the name of the Container');
        $this->containerName = ucfirst($this->containerName);

        if ($this->argument('container') && ! $this->argument('file')) {
            $this->fileName = $this->containerName;
        } else {
            $this->fileName = $this->argument('file')
                ?? $this->checkParameterOrAsk(
                    'file',
                    'Enter the name of the ' . $this->fileType . ' file',
                    $this->getDefaultFileName()
                );
        }

        $this->sectionName = $this->checkSectionOrAsk();

        if ($this->fileType !== 'Entity') {
            $this->fileName = Str::finish($this->fileName, $this->fileType);
        }

        // now fix the container and file name
        $this->containerName = $this->removeSpecialChars($this->containerName);
        $this->fileName = $this->removeSpecialChars($this->fileName);

        // and we are ready to start
        $this->printStartedMessage($this->containerName, $this->fileName);

        // get user inputs
        $this->userData = $this->getUserInputs();

        if ($this->userData === null) {
            // the user skipped this step
            return;
        }
        $this->userData = $this->sanitizeUserData($this->userData);

        // get the actual path of the output file as well as the correct filename
        $this->parsedFileName = $this->parseFileStructure($this->nameStructure, $this->userData['file-parameters']);
        $this->filePath = $this->getFilePath($this->parsePathStructure($this->pathStructure, $this->userData['path-parameters']));

        if ($this->fileSystem->exists($this->filePath)) {
            // exit the command successfully
            return 0;
        }

        // prepare stub content
        $this->stubContent = $this->getStubContent();

        $this->renderedStubContent = $this->parseStubContent(
            $this->stubContent,
            $this->stubParameters(),
        );

        $this->generateFile($this->filePath, $this->renderedStubContent);

        $this->printFinishedMessage($this->fileType);

        // exit the command successfully
        return 0;
    }

    abstract public function getUserInputs(): array;

    protected function stubParameters(): array
    {
        $layer = $this->option('ship')
            ? self::SHIP_DIRECTORY_NAME
            : self::CONTAINER_DIRECTORY_NAME;

        if ($this->sectionName) {
            $layer = sprintf(
                '%s\%s',
                $layer,
                $this->sectionName,
            );
        }

        $this->userData['stub-parameters']['layer-name'] = $layer;

        return $this->userData['stub-parameters'];
    }

    protected function validateGenerator($generator): void
    {
        if (! $generator instanceof ComponentsGenerator) {
            throw new GeneratorErrorException(
                'Your component maker command should implement ComponentsGenerator interface.'
            );
        }
    }

    protected function getFilePath($path): string
    {
        // complete the missing parts of the path
        $layerPath = $this->option('ship')
            ? self::SHIP_DIRECTORY_NAME
            : self::CONTAINER_DIRECTORY_NAME;

        if ($this->sectionName) {
            $path = sprintf(
                '%s/%s',
                $this->sectionName,
                $path,
            );
        }

        $path = sprintf(
            '%s/%s/%s/%s.%s',
            base_path(),
            self::ROOT,
            $layerPath,
            $path,
            $this->getDefaultFileExtension(),
        );

        // try to create directory
        $this->createDirectory($path);

        // return full path
        return $path;
    }

    protected function getStubPath(): string
    {
        return self::CUSTOM_STUB_PATH;
    }

    protected function getStubContent(): string
    {
        // check if there is a custom file that overrides the default stubs
        $path = app_path() . '/Ship/' . $this->getStubPath();
        $file = str_replace('*', $this->stubName, $path);

        // check if the custom file exists
        if (! $this->fileSystem->exists($file)) {
            // it does not exist - so take the default file!
            $path = __DIR__ . '/' . self::STUB_PATH;
            $file = str_replace('*', $this->stubName, $path);
        }

        // now load the stub
        return $this->fileSystem->get($file);
    }

    protected function getOptions(): array
    {
        return array_merge($this->defaultInputs, $this->inputs);
    }

    protected function getInput(string $arg, bool $trim = true): string
    {
        return $trim ? $this->trimString($this->argument($arg)) : $this->argument($arg);
    }

    protected function checkSectionOrAsk(): string
    {
        if ($value = $this->option('section')) {
            return $value;
        }

        if (Str::contains($this->containerName, '/')) {
            [$this->sectionName, $this->containerName] = explode('/', $this->containerName);

            return $this->sectionName;
        }

        if ($this->option('need_section')) {
            // there was no value provided via CLI, so ask the user..
            return $this->ask('Enter the name of the section', '');
        }

        return '';
    }

    protected function checkParameterOrAsk(string $param, string $question, ?bool $default = null): string
    {
        // check if we already have a param set
        $value = $this->option($param);
        if ($value == null) {
            // there was no value provided via CLI, so ask the user..
            $value = $this->ask($question, $default);
        }

        return $value;
    }

    protected function checkParameterOrChoice(string $param, string $question, array $choices, ?bool $default = null): string
    {
        // check if we already have a param set
        $value = $this->option($param);
        if ($value == null) {
            // there was no value provided via CLI, so ask the user..
            $value = $this->choice($question, $choices, $default);
        }

        return $value;
    }

    protected function checkParameterOrConfirm(string $param, string $question, bool $default = false): string
    {
        // check if we already have a param set
        $value = $this->option($param);
        if ($value === null) {
            // there was no value provided via CLI, so ask the user..
            $value = $this->confirm($question, $default);
        }

        return $value;
    }

    protected function sanitizeUserData(array $data): array
    {
        if (! array_key_exists('path-parameters', $data)) {
            $data['path-parameters'] = [];
        }

        if (! array_key_exists('stub-parameters', $data)) {
            $data['stub-parameters'] = [];
        }

        if (! array_key_exists('file-parameters', $data)) {
            $data['file-parameters'] = [];
        }

        return $data;
    }

    protected function getDefaultFileName(): string
    {
        return 'Default' . Str::ucfirst($this->fileType);
    }

    protected function getDefaultFileExtension(): string
    {
        return 'php';
    }

    protected function removeSpecialChars(string $str): string
    {
        // remove everything that is NOT a character or digit
        return preg_replace('/[^A-Za-z0-9]/', '', $str);
    }
}
