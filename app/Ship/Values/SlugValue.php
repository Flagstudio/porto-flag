<?php

namespace App\Ship\Values;

class SlugValue
{
    public function __construct(
        private string $slug,
    ) {
    }

    public function __toString(): string
    {
        return $this->slug;
    }
}
