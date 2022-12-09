<?php

/*
|--------------------------------------------------------------------------
| Client Container api routes
|--------------------------------------------------------------------------
|
|
|
*/

use App\Containers\Client\Http\Controllers\Api\V1\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->prefix('clients')
    ->name('clients.')
    ->group(function () {
        Route::get('/', [ClientController::class, 'show'])
            ->name('show');
    });
