<?php

namespace App\Containers\Client\Nova\Roles;

use App\Containers\Client\Contracts\Role;
use Illuminate\Support\Facades\Gate;

class Editor implements Role
{
    public function can(): bool
    {
        return Gate::check('is-editor');
    }

    public function cannot(): bool
    {
        return false;
    }
}
