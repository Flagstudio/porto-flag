<?php

namespace App\Containers\FaceControl\Tasks;

use App\Containers\Client\Domain\Entities\Client;
use App\Ship\Parents\Tasks\Task;

class SendVerificationCodeTask extends Task
{
    public function __construct(
        private readonly bool $isTestMode = false,
    ) {
    }

    public function run(Client $client): void
    {
        if ($this->isTestMode) {
            $client->generateVerifyCode();

            return;
        }

        $verifyCode = $client->generateVerifyCode();

        // Отправляем код пользователю
    }
}
