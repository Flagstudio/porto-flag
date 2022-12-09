<?php

namespace App\Ship\Captain\Providers;

use App\Containers\Settings\Domain\Models\Settings;
use App\Ship\Captain\Foundation\Facades\Captain;
use App\Ship\Captain\Loaders\ConfigsLoader;
use App\Ship\Captain\Loaders\HelperLoader;
use App\Ship\Captain\Loaders\MigrationsLoader;
use App\Ship\Captain\Loaders\RoutesLoader;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ContainersServiceProvider extends ServiceProvider
{
    public array $loaders = [];

    public function __construct($app)
    {
        parent::__construct($app);

        $this->loaders = [
            new RoutesLoader(),
            new MigrationsLoader(),
            new ConfigsLoader(),
            new HelperLoader(),
        ];
    }

    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $settings = Settings::whereSlug(Settings::METRICS_SLUG)->first();

            $fields = $settings?->fields;

            $view->with('beginScripts', $fields['scripts_begin'] ?? '')
                ->with('endScripts', $fields['scripts_end'] ?? '')
                ->with('headScripts', $fields['scripts_head'] ?? '');
        });
    }

    public function register()
    {
        $containersPaths = Captain::getContainersPaths();

        foreach ($containersPaths as $containerPath) {
            foreach ($this->loaders as $loader) {
                $loader->load($containerPath);
            }

            $this->loadProviders($containerPath);
        }
    }

    public function loadProviders(string $containerPath)
    {
        $providersPath = $containerPath . '/Providers/';

        if (! File::isDirectory($providersPath)) {
            return;
        }

        $providers = File::allFiles($providersPath);

        foreach ($providers as $provider) {
            if (! File::isFile($provider)) {
                continue;
            }

            $namespace = 'App\\' . Str::after($provider->getPathname(), '/var/www/app/');
            $namespace = Str::replace('/', '\\', $namespace);
            $namespace = Str::before($namespace, '.php');

            if (class_exists($namespace)) {
                $this->registerProvider($namespace);
            }
        }
    }

    private function registerProvider(string $namespace): void
    {
        if ($this->app->environment() === 'testing') {
            $provider = new $namespace($this->app);

            if (method_exists($provider, 'boot')) {
                $provider->boot();
            }

            if (method_exists($provider, 'register')) {
                $provider->register();
            }
        }

        $this->app->register($namespace);
    }
}
