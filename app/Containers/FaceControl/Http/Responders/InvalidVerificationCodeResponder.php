<?php

namespace App\Containers\FaceControl\Http\Responders;

use App\Ship\Parents\Responders\ErrorResponder;
use Symfony\Component\HttpFoundation\Response;

class InvalidVerificationCodeResponder extends ErrorResponder
{
    public static function fromAction(): InvalidVerificationCodeResponder
    {
        return new static(
            status: Response::HTTP_PRECONDITION_FAILED,
            message: 'Неверный код',
        );
    }
}
