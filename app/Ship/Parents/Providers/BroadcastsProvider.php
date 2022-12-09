<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Captain\Abstracts\Providers\BroadcastsProvider as AbstractBroadcastsProvider;
use function app_path;
use Illuminate\Support\Facades\Broadcast;

class BroadcastsProvider extends AbstractBroadcastsProvider
{
    public function boot(): void
    {
        Broadcast::routes();

        require app_path('Ship/Broadcasts/Routes.php');
    }
}
