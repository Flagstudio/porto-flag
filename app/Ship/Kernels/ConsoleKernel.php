<?php

namespace App\Ship\Kernels;

use App\Ship\Captain\Foundation\Facades\Captain;
use App\Ship\Captain\Loaders\CommandsLoader;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;

class ConsoleKernel extends Kernel
{
    protected $commands = [];

    protected function schedule(Schedule $schedule): void
    {
        if ($this->app->isLocal() || mb_strtolower(app()->environment()) === 'dev') {
            $schedule->command('telescope:prune')->cron('0 23 */2 * *');
        }
    }

    protected function commands()
    {
        $this->loadContainersCommands();

        $this->loadShipCommands();

        require base_path('routes/console.php');
    }

    protected function loadContainersCommands()
    {
        $containersPaths = Captain::getContainersPaths();
        $loader = new CommandsLoader();

        foreach ($containersPaths as $containerPath) {
            if ($path = $loader->load($containerPath)) {
                $this->load($path);
            }
        }
    }

    protected function loadShipCommands()
    {
        $this->load(ship_path('Commands'));

        $this->load(ship_path('Captain/Console/Commands'));
    }
}
