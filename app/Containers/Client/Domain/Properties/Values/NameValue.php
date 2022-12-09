<?php

namespace App\Containers\Client\Domain\Properties\Values;

class NameValue
{
    public function __construct(
        private string $name,
    ) {
        $this->name = trim($name);
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
