<?php

namespace App\Containers\FaceControl\Http\Controllers\Api\V1;

use App\Containers\FaceControl\Actions\GenerateVerificationCodeAction;
use App\Containers\FaceControl\Actions\ResendVerificationCodeAction;
use App\Containers\FaceControl\Http\Requests\GenerateVerificationCodeRequest;
use App\Ship\Captain\Abstracts\Responders\Responder;
use App\Ship\Parents\Controllers\ApiController;

/**
 * @group Authenticating endpoints V1
 */
class VerificationCodeController extends ApiController
{
    /**
     * Получение кода подтверждения.
     *
     * Генерируется новый код подтверждения и отправляется пользователю
     *
     * @bodyParam phone string required Номер телефона (+79998887766)
     *
     * @response status=200 scenario="success" {
     *      "data": {
     *          "message": "success",
     *      }
     * }
     */
    public function show(GenerateVerificationCodeRequest $request): Responder
    {
        return $this->action(
            GenerateVerificationCodeAction::class,
            $request->transported(),
        );
    }

    /**
     * Повторная генерация и отправка кода подтверждения
     *
     * Генерируется новый код подтверждения и отправляется пользователю
     *
     * @bodyParam phone string required Номер телефона (+79998887766)
     *
     * @response status=200 scenario="success" {
     *      "data": []
     * }
     */
    public function update(GenerateVerificationCodeRequest $request): Responder
    {
        return $this->action(
            ResendVerificationCodeAction::class,
            $request->transported(),
        );
    }
}
