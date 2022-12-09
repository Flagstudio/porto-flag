<?php

/*
|--------------------------------------------------------------------------
| Client Container api routes
|--------------------------------------------------------------------------
|
|
|
*/

use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('v1.')
    ->group(container_path('Client/Routes/api_v1.php'));
