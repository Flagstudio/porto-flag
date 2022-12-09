<?php

namespace App\Ship\Captain\Loaders;

use Illuminate\Support\Facades\App;

trait ProvidersLoaderTrait
{
    protected array $serviceProviders = [];

    private function loadProvider(string $providerFullName): void
    {
        App::register($providerFullName);
    }

    public function loadServiceProviders(): void
    {
        foreach ($this->serviceProviders as $provider) {
            $this->loadProvider($provider);
        }
    }
}
