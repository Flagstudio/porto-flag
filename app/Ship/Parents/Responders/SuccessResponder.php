<?php

namespace App\Ship\Parents\Responders;

use App\Ship\Captain\Abstracts\Responders\Responder;
use Symfony\Component\HttpFoundation\Response;

class SuccessResponder extends Responder
{
    public int $status = Response::HTTP_OK;

    public array $data;

    public function toResponse($request): Response
    {
        return response()->json([
            'status' => $this->status,
            'data' => $this->data,
        ], $this->status);
    }
}
