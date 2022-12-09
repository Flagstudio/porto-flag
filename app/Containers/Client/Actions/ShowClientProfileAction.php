<?php

namespace App\Containers\Client\Actions;

use App\Containers\Client\Domain\Factories\ClientFactory;
use App\Containers\Client\Domain\Models\User;
use App\Ship\Captain\Abstracts\Responders\Responder;
use App\Ship\Parents\Actions\Action;

class ShowClientProfileAction extends Action
{
    public function __construct(
        private readonly ClientFactory $clientFactory,
    ) {
    }

    public function run(User $user): Responder
    {
        $client = $this->clientFactory->fromModel($user);

        return $this->success([
            'name' => $client->getName(),
            'phone' => $client->getPhone(),
            'email' => $client->getEmail(),
            'birthday' => $client->getBirthday() === '0001-01-01' ? null : $client->getBirthday(),
        ]);
    }
}
