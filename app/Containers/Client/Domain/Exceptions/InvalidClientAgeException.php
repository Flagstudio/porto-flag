<?php

namespace App\Containers\Client\Domain\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidClientAgeException extends Exception
{
    public $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    public $message = 'Получена недопустимая дата рождения клиента.';

    public $code = 0;
}
