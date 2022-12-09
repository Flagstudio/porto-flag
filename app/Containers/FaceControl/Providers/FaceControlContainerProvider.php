<?php

namespace App\Containers\FaceControl\Providers;

use App\Containers\FaceControl\Tasks\SendVerificationCodeTask;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class FaceControlContainerProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when(SendVerificationCodeTask::class)
            ->needs('$isTestMode')
            ->giveConfig('facecontrol.register_test_mode');
    }
}
