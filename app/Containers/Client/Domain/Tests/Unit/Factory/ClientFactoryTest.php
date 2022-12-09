<?php

namespace App\Containers\Client\Domain\Tests\Unit\Factory;

use App\Containers\Client\Domain\Factories\ClientFactory;
use App\Containers\Client\Domain\Models\User;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientFactoryTest extends TestCase
{
    private readonly ClientFactory $clientFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->clientFactory = new ClientFactory();
    }

    public function testCreateFromModel()
    {
        $id = 10;
        $uuid = Str::uuid()->toString();
        $verifyCode = 1234;

        $model = User::create([
            'id' => $id,
            'password' => bcrypt($verifyCode),
            'phone' => '+79999999111',
            'name' => '',
            'email' => '',
        ]);

        $model->verificationCode()->create([
            'code' => Hash::make($verifyCode),
            'expires_in' => now()->addMinutes(10),
        ]);

        $entity = $this->clientFactory->fromModel($model);

        $this->assertEquals($entity->getId(), $id);
        $this->assertTrue($entity->checkVerifyCode($verifyCode));
    }
}
