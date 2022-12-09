<?php

namespace App\Containers\Client\Nova\Roles;

use App\Containers\Client\Contracts\Role;
use Illuminate\Support\Facades\Gate;

class Admin implements Role
{
    public function can(): bool
    {
        return Gate::check('is-admin');
    }

    public function cannot(): bool
    {
        return false;
    }
}
