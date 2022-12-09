<?php

namespace App\Ship\Captain\Providers;

use App\Ship\Captain\Abstracts\Providers\MainProvider as AbstractMainProvider;
use App\Ship\Nova\Providers\NovaServiceProvider;
use App\Ship\Providers\TelescopeServiceProvider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CaptainProvider extends AbstractMainProvider
{
    public array $serviceProviders = [
        RouteServiceProvider::class,
        NovaServiceProvider::class,
    ];

    public function boot(): void
    {
        parent::boot();

        Carbon::setLocale(config('app.locale'));

        if ($this->app->isProduction()) {
            error_reporting(E_ALL ^ E_NOTICE);
        }
    }

    public function register(): void
    {
        parent::register();

        if ($this->app->isLocal() || mb_strtolower(app()->environment()) === 'dev') {
            $this->app->register(TelescopeServiceProvider::class);
        }

        Model::preventLazyLoading(! app()->isProduction());
    }
}
