<?php

namespace App\Ship\Captain\Foundation\Components;

use App\Ship\Parents\ViewModels\ViewModel;

class CallViewModel extends CallComponent
{
    public function call(...$parameters)
    {
        $args = array_slice($parameters, 1);

        return new $parameters[0](...$args);
    }

    protected function parentInstance($instance): bool
    {
        return $instance instanceof ViewModel;
    }
}
