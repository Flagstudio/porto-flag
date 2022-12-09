<?php

namespace App\Containers\FaceControl\Http\Responders;

use App\Ship\Parents\Responders\SuccessResponder;
use Symfony\Component\HttpFoundation\Response;

class ClientAlreadyExistsResponder extends SuccessResponder
{
    public static function fromAction(): ClientAlreadyExistsResponder
    {
        return new static(
            status: Response::HTTP_OK,
            data: [
                'is_new' => false,
            ],
        );
    }
}
