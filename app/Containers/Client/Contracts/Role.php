<?php

namespace App\Containers\Client\Contracts;

interface Role
{
    public function can(): bool;

    public function cannot(): bool;
}
