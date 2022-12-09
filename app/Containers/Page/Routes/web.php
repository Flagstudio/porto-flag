<?php

/*
|--------------------------------------------------------------------------
| Page Container web routes
|--------------------------------------------------------------------------
|
|
|
*/

use App\Containers\Page\Http\Controllers\Web\MainPageController;
use Illuminate\Support\Facades\Route;

Route::get('', MainPageController::class)
    ->name('main');
