<?php

namespace App\Containers\FaceControl\Actions;

use App\Containers\Client\Domain\Repositories\ClientRepository;
use App\Containers\FaceControl\Actions\SubActions\GenerateVerificationCodeSubAction;
use App\Containers\FaceControl\Transfers\Transporters\GenerateVerificationCodeTransporter;
use App\Ship\Captain\Abstracts\Responders\Responder;
use App\Ship\Parents\Actions\Action;
use App\Ship\Values\PhoneValue;

class ResendVerificationCodeAction extends Action
{
    public function __construct(
        private ClientRepository $clientRepository,
    ) {
    }

    public function run(GenerateVerificationCodeTransporter $transporter): Responder
    {
        $client = $this->clientRepository->byPhone(
            new PhoneValue($transporter->phone)
        );

        $this->subAction(
            GenerateVerificationCodeSubAction::class,
            $client,
        );

        return $this->success();
    }
}
