<?php

namespace App\Containers\Page\ViewModels;

use App\Containers\Page\Domain\Models\Page;
use App\Ship\Parents\ViewModels\ViewModel;

class MainPageViewModel extends ViewModel
{
    public function __construct(
        private readonly Page $mainPage,
    ) {
        parent::__construct();
    }

    public function defaultView(): string
    {
        return 'main.index';
    }

    public function title(): string
    {
        return $this->mainPage->title;
    }
}
