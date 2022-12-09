<?php

namespace App\Containers\Client\Domain\Properties\Values;

class VerifyCodeValue
{
    public function __construct(
        private string $code = ''
    ) {
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
