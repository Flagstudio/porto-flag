<?php

namespace App\Containers\FaceControl\Tests\Functional;

use App\Containers\Client\Domain\Models\User;
use App\Containers\FaceControl\Actions\GenerateVerificationCodeAction;
use App\Containers\FaceControl\Actions\ResendVerificationCodeAction;
use App\Containers\FaceControl\Transfers\Transporters\GenerateVerificationCodeTransporter;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class VerificationCodeTest extends TestCase
{
    private const JSON_RESPONSE = [
        'status',
        'data' => [
            'is_new',
        ],
    ];

    public function testGenerate()
    {
        $user = User::first();

        $response = $this->action(
            GenerateVerificationCodeAction::class,
            new GenerateVerificationCodeTransporter(
                phone: '+79999999999'
            ),
        );

        $this->assertEquals(Response::HTTP_OK, $response->status);

        $this->assertDatabaseHas(
            'personal_verification_codes',
            [
                'user_id' => $user->id,
            ],
        );
    }

    public function testRegenerate()
    {
        $code = Hash::make(1234);
        $user = User::first();
        $user->verificationCode()->create([
            'code' => $code,
            'expires_in' => now()->addMinutes(10),
        ]);

        $this->assertDatabaseHas(
            'personal_verification_codes',
            [
                'user_id' => $user->id,
                'code' => $code,
            ],
        );

        $response = $this->action(
            ResendVerificationCodeAction::class,
            new GenerateVerificationCodeTransporter(
                phone: $user->phone
            ),
        );

        $this->assertEquals(Response::HTTP_OK, $response->status);

        $this->assertDatabaseMissing(
            'personal_verification_codes',
            [
                'user_id' => $user->id,
                'code' => $code,
            ],
        );
    }
}
