<?php

namespace App\Ship\Captain\Console\Traits;

trait FormatterTrait
{
    protected function trimString(string $string): string
    {
        return trim($string);
    }

    public function capitalize(string $word): string
    {
        return ucfirst($word);
    }

    public function prependOperationToName(string $operation, string $class): string
    {
        $className = $class;

        return $operation . $this->capitalize($className);
    }
}
