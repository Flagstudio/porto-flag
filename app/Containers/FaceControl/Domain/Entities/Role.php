<?php

namespace App\Containers\FaceControl\Domain\Entities;

use App\Containers\Client\Domain\Properties\Values\PermissionsValue;
use App\Ship\Parents\Entities\Entity;

class Role extends Entity
{
    private PermissionsValue $permissions;
}
