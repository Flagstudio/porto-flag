<?php

namespace App\Ship\Parents\Entities;

use App\Ship\Captain\Abstracts\Entities\AbstractEntity;
use App\Ship\Values\IdValue;

abstract class Entity extends AbstractEntity
{
    protected IdValue $id;

    public function setId(IdValue $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id->getValue();
    }
}
