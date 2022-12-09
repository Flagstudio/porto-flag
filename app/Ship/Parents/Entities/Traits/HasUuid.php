<?php

namespace App\Ship\Parents\Entities\Traits;

use App\Ship\Values\UuidValue;

trait HasUuid
{
    private UuidValue $uuid;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(UuidValue $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }
}
