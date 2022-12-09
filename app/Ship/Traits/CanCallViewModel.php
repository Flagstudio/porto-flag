<?php

namespace App\Ship\Traits;

trait CanCallViewModel
{
    public function viewModel(...$parameters)
    {
        return resolve(\App\Ship\Captain\Foundation\Components\CallViewModel::class)
            ->call(...$parameters);
    }
}
