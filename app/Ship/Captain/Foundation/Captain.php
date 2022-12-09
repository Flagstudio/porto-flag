<?php

namespace App\Ship\Captain\Foundation;

use App\Ship\Captain\Exceptions\ClassDoesNotExistException;
use App\Ship\Captain\Exceptions\MissingContainerException;
use App\Ship\Captain\Exceptions\WrongConfigurationsException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Captain
{
    public function getContainersNamespace(): string
    {
        return Config::get('Captain.containers.namespace');
    }

    public function getContainersNames(): array
    {
        $containersNames = [];

        foreach ($this->getContainersPaths() as $containersPath) {
            $containersNames[] = basename($containersPath);
        }

        return $containersNames;
    }

    public function getShipFoldersNames(): array
    {
        $portFoldersNames = [];

        foreach ($this->getShipPath() as $portFoldersPath) {
            $portFoldersNames[] = basename($portFoldersPath);
        }

        return $portFoldersNames;
    }

    public function getContainersPaths(): array
    {
        $containers = File::directories(app_path('Containers'));
        $sections = $this->getSectionsPaths();

        $onlyContainers = array_diff($containers, $sections);

        foreach ($sections as $section) {
            $onlyContainers = [
                ...$onlyContainers,
                ...File::directories($section),
            ];
        }

        return $onlyContainers;
    }

    public function getSectionsPaths(): array
    {
        $inContainers = File::directories(app_path('Containers'));

        $sections = [];

        foreach ($inContainers as $container) {
            if (! $this->isContainer($container)) {
                $sections[] = $container;
            }
        }

        return $sections;
    }

    private function isContainer(string $sectionPath): bool
    {
        $subDirs = File::directories($sectionPath);

        foreach ($subDirs as $dir) {
            $dirName = Str::afterLast($dir, '/');

            if (in_array($dirName, $this->getComponentsList())) {
                return true;
            }
        }

        return false;
    }

    private function getComponentsList(): array
    {
        return [
            'Actions',
            'Domain',
            'Http',
            'Routes',
            'Tasks',
        ];
    }

    public function getShipPath(): array
    {
        return File::directories(app_path('Ship'));
    }

    public function getClassObjectFromFile($filePathName)
    {
        $classString = $this->getClassFullNameFromFile($filePathName);

        return new $classString();
    }

    public function getClassFullNameFromFile(string $filePathName): string
    {
        return $this->getClassNamespaceFromFile($filePathName) . '\\' . $this->getClassNameFromFile($filePathName);
    }

    protected function getClassNamespaceFromFile(string $filePathName): ?string
    {
        $src = file_get_contents($filePathName);

        $tokens = token_get_all($src);
        $count = count($tokens);
        $i = 0;
        $namespace = '';
        $namespace_ok = false;
        while ($i < $count) {
            $token = $tokens[$i];

            if (! (is_array($token) && $token[0] === T_NAMESPACE)) {
                $i++;

                continue;
            }

            // Found namespace declaration
            $i++;
            while ($i < $count) {
                if ($tokens[$i] === ';') {
                    $namespace_ok = true;
                    $namespace = trim($namespace);

                    break;
                }
                $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
            }

            break;
        }

        if (! $namespace_ok) {
            return null;
        }

        return $namespace;
    }

    protected function getClassNameFromFile(string $filePathName): string
    {
        $php_code = file_get_contents($filePathName);

        $classes = [];
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] === T_CLASS
                && $tokens[$i - 1][0] === T_WHITESPACE
                && $tokens[$i][0] === T_STRING
            ) {
                $class_name = $tokens[$i][1];
                $classes[] = $class_name;
            }
        }

        return $classes[0];
    }

    public function stringStartsWith(string $word, string $startsWith): bool
    {
        return str_starts_with($word, $startsWith);
    }

    public function uncamelize(string $word, string $splitter = ' ', bool $uppercase = true): string
    {
        $word = preg_replace(
            '/(?!^)[[:upper:]][[:lower:]]/',
            '$0',
            preg_replace('/(?!^)[[:upper:]]+/', $splitter . '$0', $word)
        );

        return $uppercase ? ucwords($word) : $word;
    }

    public function getLoginWebPageName(): string
    {
        $loginPage = Config::get('Captain.containers.login-page-url');

        if (is_null($loginPage)) {
            throw new WrongConfigurationsException();
        }

        return $loginPage;
    }

    public function buildClassFullName(string $containerName, string $className): string
    {
        return 'App\Containers\\' . $containerName . '\\' . $this->getClassType($className) . 's\\' . $className;
    }

    public function getClassType(string $className): string
    {
        $array = preg_split('/(?=[A-Z])/', $className);

        return end($array);
    }

    public function verifyContainerExist(string $containerName): void
    {
        if (! is_dir(app_path('Containers/' . $containerName))) {
            throw new MissingContainerException("Container ({$containerName}) is not installed.");
        }
    }

    public function verifyClassExist(string $className): void
    {
        if (! class_exists($className)) {
            throw new ClassDoesNotExistException("Class ({$className}) is not installed.");
        }
    }
}
