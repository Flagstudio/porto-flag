<?php

namespace App\Ship\Captain\Abstracts\Responders;

use Illuminate\Contracts\Support\Responsable;
use Spatie\DataTransferObject\DataTransferObject;

abstract class Responder extends DataTransferObject implements Responsable
{
    public int $status;
}
