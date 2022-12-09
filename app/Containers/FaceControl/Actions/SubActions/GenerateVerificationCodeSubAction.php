<?php

namespace App\Containers\FaceControl\Actions\SubActions;

use App\Containers\Client\Domain\Commands\UpdateClientCommand;
use App\Containers\Client\Domain\Entities\Client;
use App\Containers\FaceControl\Tasks\SendVerificationCodeTask;
use App\Ship\Parents\Actions\SubAction;

class GenerateVerificationCodeSubAction extends SubAction
{
    public function run(Client $client): void
    {
        $this->task(
            SendVerificationCodeTask::class,
            $client,
        );

        $this->command(
            UpdateClientCommand::class,
            $client,
        );
    }
}
