<?php

namespace App\Containers\Client\Domain\Tests\Unit\Repositories;

use App\Containers\Client\Domain\Factories\ClientFactory;
use App\Containers\Client\Domain\Models\User;
use App\Containers\Client\Domain\Repositories\ClientRepository;
use App\Ship\Parents\Tests\PhpUnit\TestCase;
use App\Ship\Values\PhoneValue;

class ClientRepositoryTest extends TestCase
{
    private readonly ClientFactory $clientFactory;

    private readonly ClientRepository $clientRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->clientFactory = resolve(ClientFactory::class);
        $this->clientRepository = resolve(ClientRepository::class);
    }

    public function testClientExists()
    {
        $user = User::factory()
            ->create([
                'phone' => '+79993332233',
            ]);

        $client = $this->clientFactory
            ->fromModel($user);

        $exists = $this->clientRepository->exists($client);
        $missing = $this->clientRepository->missing($client);

        $this->assertTrue($exists);
        $this->assertFalse($missing);
    }

    public function testClientDoesntExists()
    {
        $client = $this->clientFactory
            ->new(new PhoneValue('+79993332233'));

        $exists = $this->clientRepository->exists($client);
        $missing = $this->clientRepository->missing($client);

        $this->assertFalse($exists);
        $this->assertTrue($missing);
    }
}
