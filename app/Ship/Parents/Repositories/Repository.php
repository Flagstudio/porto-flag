<?php

namespace App\Ship\Parents\Repositories;

use App\Ship\Captain\Abstracts\Repositories\Repository as AbstractRepository;

abstract class Repository extends AbstractRepository
{
    public function model(): string
    {
        return '';
    }
}
