<?php

namespace App\Containers\FaceControl\Http\Responders;

use App\Ship\Parents\Responders\SuccessResponder;
use Symfony\Component\HttpFoundation\Response;

class ClientRegisteredResponder extends SuccessResponder
{
    public static function fromAction(): ClientRegisteredResponder
    {
        return new static(
            status: Response::HTTP_CREATED,
            data: [
                'is_new' => true,
            ],
        );
    }
}
