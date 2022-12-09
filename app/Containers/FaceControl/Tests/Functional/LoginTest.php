<?php

namespace App\Containers\FaceControl\Tests\Functional;

use App\Containers\Client\Domain\Models\User;
use App\Containers\FaceControl\Actions\LoginClientAction;
use App\Containers\FaceControl\Transfers\Transporters\LoginTransporter;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends TestCase
{
    public function testClientCanLogin()
    {
        $code = Hash::make(1234);
        $user = User::first();
        $user->verificationCode()->create([
            'code' => $code,
            'expires_in' => now()->addMinutes(10),
        ]);

        $response = $this->action(
            LoginClientAction::class,
            new LoginTransporter(
                phone: $user->phone,
                verify_code: 1234,
            ),
        );

        $this->assertEquals(Response::HTTP_OK, $response->status);
        $this->assertArrayHasKey('accessToken', $response->data);
        $this->assertArrayHasKey('expires_in', $response->data);
    }
}
