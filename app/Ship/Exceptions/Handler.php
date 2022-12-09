<?php

namespace App\Ship\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [

    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $Throwable): void
    {
        parent::report($Throwable);
    }

    public function render($request, Throwable $Throwable): Response
    {
        return parent::render($request, $Throwable);
    }
}
