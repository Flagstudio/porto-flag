<?php

namespace App\Ship\Parents\Tests\PhpUnit;

use App\Containers\Client\Domain\Models\User;
use App\Ship\Captain\Abstracts\Tests\PhpUnit\TestCase as AbstractTestCase;
use App\Ship\Traits\CanCallAction;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;

abstract class TestCase extends AbstractTestCase
{
    use CanCallAction;

    protected const JSON_TOKEN_STRUCTURE = [
        'status',
        'data' => [
            'accessToken',
            'expires_in',
        ],
    ];

    protected const FAILED_REQUEST = [
        'status',
        'message',
    ];


    protected string $userToken;

    public function setUp(): void
    {
        parent::setUp();

        $this->becomeAuthenticated();
    }

    protected function becomeAuthenticated(?User $user = null): void
    {
        $user = $user ?? User::first();

        $this->userToken = $user->createToken($user->phone)
            ->plainTextToken;
    }

    protected function asAuthenticated(): TestCase
    {
        return $this->withHeader('Authorization', 'Bearer ' . $this->userToken);
    }

    protected function forgotToken(): void
    {
        $this->userToken = '';
    }

    protected function fakeMedia(string $name = 'image.png', int $size = 64): File
    {
        return UploadedFile::fake()->create($name, $size);
    }
}
