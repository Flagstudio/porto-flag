<?php

namespace App\Containers\Client\Domain\Commands;

use App\Containers\Client\Domain\Entities\Client;
use App\Containers\Client\Domain\Models\User;
use App\Ship\Parents\Domain\Commands\ParentCommand;

class UpdateClientCommand extends ParentCommand
{
    public function run(Client $client)
    {
        $model = User::wherePhone($client->getPhone())->first();

        $model->update([
            'phone' => $client->getPhone(),
            'name' => $client->getName(),
            'email' => $client->getEmail() ?: null,
            'birthday' => $client->getBirthday(),
        ]);

        $model->verificationCode()->delete();

        if ($client->getVerifyCode()) {
            $model->verificationCode()->create([
                'code' => $client->getVerifyCode(),
                'expires_in' => now()->addMinutes(10),
            ]);
        }
    }
}
