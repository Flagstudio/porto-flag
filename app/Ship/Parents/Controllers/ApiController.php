<?php

namespace App\Ship\Parents\Controllers;

use App\Ship\Captain\Abstracts\Controllers\Controller;
use App\Ship\Traits\CanCallAction;

abstract class ApiController extends Controller
{
    use CanCallAction;
}
