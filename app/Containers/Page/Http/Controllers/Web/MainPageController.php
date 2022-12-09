<?php

namespace App\Containers\Page\Http\Controllers\Web;

use App\Containers\Page\Domain\Repositories\PageRepository;
use App\Containers\Page\ViewModels\MainPageViewModel;
use App\Ship\Parents\Controllers\WebController;

class MainPageController extends WebController
{
    public function __construct(
        private readonly PageRepository $pageRepository,
    ) {
    }

    public function __invoke()
    {
        return $this->viewModel(
            MainPageViewModel::class,
            $this->pageRepository->main(),
        );
    }
}
