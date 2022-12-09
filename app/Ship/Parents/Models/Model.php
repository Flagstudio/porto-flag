<?php

namespace App\Ship\Parents\Models;

use App\Ship\Captain\Abstracts\Models\Model as AbstractEntity;

abstract class Model extends AbstractEntity
{
    protected $guarded = [];
}
