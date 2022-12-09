<?php

namespace App\Ship\Captain\Console\Traits;

trait ParserTrait
{
    public function parsePathStructure(string $path, array $data): string
    {
        $path = str_replace(array_map([$this, 'maskPathVariables'], array_keys($data)), array_values($data), $path);

        return str_replace('*', $this->parsedFileName, $path);
    }

    public function parseFileStructure(string $filename, array $data): string
    {
        return str_replace(array_map([$this, 'maskFileVariables'], array_keys($data)), array_values($data), $filename);
    }

    public function parseStubContent(string $stub, array $data): string
    {
        return str_replace(array_map([$this, 'maskStubVariables'], array_keys($data)), array_values($data), $stub);
    }

    private function maskPathVariables(string $key): string
    {
        return '{' . $key . '}';
    }

    private function maskFileVariables(string $key): string
    {
        return '{' . $key . '}';
    }

    private function maskStubVariables(string $key): string
    {
        return '{{' . $key . '}}';
    }
}
