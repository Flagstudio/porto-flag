<?php

use App\Containers\FaceControl\Http\Controllers\Api\V1\LoginController;
use App\Containers\FaceControl\Http\Controllers\Api\V1\VerificationCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::get('/verification-code', [VerificationCodeController::class, 'show'])
            ->name('code.send');

        Route::put('/verification-code', [VerificationCodeController::class, 'update'])
            ->name('code.resend');

        Route::post('/login', loginController::class)
            ->name('login');
    });
