<?php

namespace App\Containers\Client\Tests\Functional;

use App\Containers\Client\Actions\ShowClientProfileAction;
use App\Containers\Client\Domain\Models\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;

class ClientTest extends TestCase
{
    public function testClientInfo()
    {
        $user = User::first();

        $clientInfo = $this->action(
            ShowClientProfileAction::class,
            User::first(),
        );

        $this->assertEquals($user->name, $clientInfo->data['name']);
        $this->assertEquals($user->phone, $clientInfo->data['phone']);
        $this->assertEquals($user->email, $clientInfo->data['email']);
        $this->assertEquals($user->birthday->toDateString(), $clientInfo->data['birthday']);
    }
}
