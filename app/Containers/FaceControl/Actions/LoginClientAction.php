<?php

namespace App\Containers\FaceControl\Actions;

use App\Containers\Client\Domain\Repositories\ClientRepository;
use App\Containers\FaceControl\Exceptions\InvalidVerificationCodeException;
use App\Containers\FaceControl\Http\Responders\InvalidVerificationCodeResponder;
use App\Containers\FaceControl\Tasks\GenerateTokenTask;
use App\Containers\FaceControl\Transfers\Transporters\LoginTransporter;
use App\Ship\Captain\Abstracts\Responders\Responder;
use App\Ship\Parents\Actions\Action;
use App\Ship\Values\PhoneValue;

class LoginClientAction extends Action
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function run(LoginTransporter $transporter): Responder
    {
        try {
            $client = $this->clientRepository->byPhone(
                new PhoneValue($transporter->phone)
            );

            if (! config('facecontrol.register_test_mode')) {
                if (! $client->checkVerifyCode($transporter->verifyCode)) {
                    throw new InvalidVerificationCodeException();
                }
            }

            $token = $this->task(
                GenerateTokenTask::class,
                $client,
            );

            return $this->success([
                'accessToken' => $token,
                'expires_in' => now()->addYear(),
            ]);
        } catch (\Exception) {
            return InvalidVerificationCodeResponder::fromAction();
        }
    }
}
