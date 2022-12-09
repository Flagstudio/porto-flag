<?php

namespace App\Ship\Nova\Providers;

use App\Ship\Nova\Controllers\ResourceUpdateController;
use Flagstudio\NovaContacts\NovaContacts;
use Flagstudio\NovaInstructions\NovaInstructions;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Nova::style('admin', public_path('css/nova.css'));

        if (! App::isLocal()) {
            Nova::$themes = array_map(fn ($theme) => Str::replace('http://', 'https://', $theme), Nova::$themes);
        }

        Nova::userTimezone(fn () => config('app.timezone'));
    }

    public function register(): void
    {
        $this->app->bind(
            'Laravel\Nova\Http\Controllers\ResourceUpdateController',
            ResourceUpdateController::class,
        );
    }

    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return $user->isAdmin() || $user->isEditor();
        });
    }

    protected function cards(): array
    {
        return [
            new NovaContacts(),
            new NovaInstructions(),
        ];
    }

    protected function resources(): void
    {
        Nova::resourcesIn(app_path('Containers'));
    }
}
