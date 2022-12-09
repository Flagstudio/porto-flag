<?php

namespace App\Containers\Client\Domain\Repositories;

use App\Containers\Client\Domain\Entities\Client;
use App\Containers\Client\Domain\Factories\ClientFactory;
use App\Containers\Client\Domain\Models\User;
use App\Containers\FaceControl\Domain\Exceptions\ClientNotFoundException;
use App\Ship\Parents\Repositories\Repository;
use App\Ship\Values\PhoneValue;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Auth;

class ClientRepository extends Repository
{
    public function __construct(
        Application $app,
        private ClientFactory $clientFactory,
    ) {
        parent::__construct($app);
    }

    public function model(): string
    {
        return User::class;
    }

    public function current(): Client
    {
        return $this->clientFactory->fromModel(
            Auth::user()
        );
    }

    public function byPhone(PhoneValue $phone): Client
    {
        $client = $this->wherePhone($phone)->first();

        if (! $client) {
            throw new ClientNotFoundException;
        }

        return $this->clientFactory->fromModel($client);
    }

    public function exists(Client $client): bool
    {
        return $this->wherePhone($client->getPhone())->exists();
    }

    public function missing(Client $client): bool
    {
        return ! $this->exists($client);
    }
}
