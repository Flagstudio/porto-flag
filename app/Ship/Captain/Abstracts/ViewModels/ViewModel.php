<?php

namespace App\Ship\Captain\Abstracts\ViewModels;

abstract class ViewModel extends \Spatie\ViewModels\ViewModel
{
    protected $ignore = ['jsonSerialize'];

    public function __construct()
    {
        $this->view = $this->defaultView();
    }

    abstract public function defaultView(): string;
}
