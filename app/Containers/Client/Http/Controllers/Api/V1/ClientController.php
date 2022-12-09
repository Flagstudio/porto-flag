<?php

namespace App\Containers\Client\Http\Controllers\Api\V1;

use App\Containers\Client\Actions\ShowClientProfileAction;
use App\Ship\Captain\Abstracts\Responders\Responder;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;

/**
 * @group Client endpoints V1
 */
class ClientController extends ApiController
{
    /**
     * Получить информацию о пользователе
     *
     * @authenticated
     *
     * @response status=200 scenario="success" {
     *      "data": {
     *          "name": "Totoro",
     *          "phone": "+79999999999",
     *          "email": "client@porto.ru",
     *          "birthday": 2000-01-01,
     *      }
     * }
     */
    public function show(): Responder
    {
        return $this->action(
            ShowClientProfileAction::class,
            Auth::user(),
        );
    }
}
