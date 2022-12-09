<?php

namespace App\Containers\FaceControl\Tasks;

use App\Containers\Client\Domain\Entities\Client;
use App\Containers\Client\Domain\Models\User;
use App\Ship\Parents\Tasks\Task;

class GenerateTokenTask extends Task
{
    public function run(Client $client): string
    {
        $user = User::wherePhone($client->getPhone())->first();

        $user->tokens()->delete();

        return $user->createToken($client->getPhone())->plainTextToken;
    }
}
