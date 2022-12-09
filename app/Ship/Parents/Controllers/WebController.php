<?php

namespace App\Ship\Parents\Controllers;

use App\Ship\Captain\Abstracts\Controllers\Controller as AbstractWebController;
use App\Ship\Traits\CanCallViewModel;

abstract class WebController extends AbstractWebController
{
    use CanCallViewModel;
}
