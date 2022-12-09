<?php

namespace App\Ship\Parents\Actions;

use App\Ship\Captain\Abstracts\Actions\SubAction as AbstractSubAction;
use App\Ship\Captain\Abstracts\Responders\Responder;
use App\Ship\Parents\Responders\ErrorResponder;
use App\Ship\Parents\Responders\SuccessResponder;
use App\Ship\Traits\CanCallCommand;
use App\Ship\Traits\CanCallTask;

abstract class SubAction extends AbstractSubAction
{
    use CanCallTask;
    use CanCallCommand;

    protected function success(array $data): Responder
    {
        $data = [
            'data' => $data,
        ];

        return new SuccessResponder($data);
    }

    protected function error(string $message): Responder
    {
        $data = [
            'message' => $message,
        ];

        return new ErrorResponder($data);
    }

    protected function response(Responder|string $responder, array|string $data = []): Responder
    {
        $data = $data ?: ['data' => []];

        return new $responder($data);
    }
}
