<?php

namespace App\Ship\Captain\Abstracts\Transporters;

use App\Ship\Parents\Requests\Request;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
abstract class Transporter extends DataTransferObject
{
    public static function fromRequest(Request $request): static
    {
        return new static(
            $request->validated()
        );
    }
}
