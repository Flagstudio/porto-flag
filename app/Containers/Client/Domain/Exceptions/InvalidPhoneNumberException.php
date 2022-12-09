<?php

namespace App\Containers\Client\Domain\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidPhoneNumberException extends Exception
{
    public $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Получен неверный номер телефона.';

    public $code = 0;
}
