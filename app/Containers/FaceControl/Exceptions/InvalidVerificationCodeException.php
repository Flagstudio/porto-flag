<?php

namespace App\Containers\FaceControl\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidVerificationCodeException extends Exception
{
    public $httpStatusCode = Response::HTTP_PRECONDITION_FAILED;

    public $message = 'Invalid verification code.';

    public $code = 0;
}
