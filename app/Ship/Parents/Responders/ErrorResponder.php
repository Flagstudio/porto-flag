<?php

namespace App\Ship\Parents\Responders;

use App\Ship\Captain\Abstracts\Responders\Responder;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponder extends Responder
{
    public int $status = Response::HTTP_BAD_REQUEST;

    public string $message;

    public function toResponse($request): Response
    {
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
        ], $this->status);
    }
}
