<?php

namespace App\Ship\Captain\Foundation\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string
     */
    protected function redirectTo($request)
    {
        if (Str::startsWith($request->route()->uri(), 'api/')) {
            abort(401);
        }

        return route('login');
    }
}
