<?php

namespace App\Containers\FaceControl\Http\Controllers\Api\V1;

use App\Containers\FaceControl\Actions\LoginClientAction;
use App\Containers\FaceControl\Http\Requests\LoginRequest;
use App\Ship\Captain\Abstracts\Responders\Responder;
use App\Ship\Parents\Controllers\ApiController;

/**
 * @group Authenticating endpoints V1
 */
class LoginController extends ApiController
{
    /**
     * Аутентификация пользователя
     *
     * Происходит по номеру телефона и коду подстверждения
     *
     * @bodyParam phone string required Номер телефона
     * @bodyParam verify_code string required Код подтверждения
     *
     * @response status=200 scenario="success" {
     *      "data": {
     *          "accessToken": "1|dfed415f6a14sd56",
     *          "expires_in": "2022-12-21"
     *      }
     * }
     */
    public function __invoke(LoginRequest $request): Responder
    {
        return $this->action(
            LoginClientAction::class,
            $request->transported(),
        );
    }
}
