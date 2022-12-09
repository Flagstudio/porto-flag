<?php

namespace App\Containers\Client\Domain\Tests\Unit\Commands;

use App\Containers\Client\Domain\Commands\UpdateClientCommand;
use App\Containers\Client\Domain\Factories\ClientFactory;
use App\Containers\Client\Domain\Models\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;

class UpdateClientTest extends TestCase
{
    public function testGenerateVerificationCode()
    {
        $user = User::first();

        $this->assertDatabaseMissing(
            'personal_verification_codes',
            [
                'user_id' => $user->id,
            ],
        );

        $client = resolve(ClientFactory::class)
            ->fromModel($user);

        $client->generateVerifyCode();

        resolve(UpdateClientCommand::class)->run($client);

        $this->assertDatabaseHas(
            'personal_verification_codes',
            [
                'user_id' => $user->id,
            ],
        );
    }

    public function testUpdateVerificationCode()
    {
        $user = User::first();

        $this->assertDatabaseMissing(
            'personal_verification_codes',
            [
                'user_id' => $user->id,
            ],
        );

        $client = resolve(ClientFactory::class)
            ->fromModel($user);

        $client->generateVerifyCode();
        $verifyCode = $client->getVerifyCode();

        resolve(UpdateClientCommand::class)->run($client);

        $this->assertDatabaseHas(
            'personal_verification_codes',
            [
                'user_id' => $user->id,
                'code' => $verifyCode,
            ],
        );

        $client->generateVerifyCode();

        resolve(UpdateClientCommand::class)->run($client);

        $this->assertDatabaseMissing(
            'personal_verification_codes',
            [
                'user_id' => $user->id,
                'code' => $verifyCode,
            ],
        );
    }
}
