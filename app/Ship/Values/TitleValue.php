<?php

namespace App\Ship\Values;

class TitleValue
{
    public function __construct(
        private string $title
    ) {
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
