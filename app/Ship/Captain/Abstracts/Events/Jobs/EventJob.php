<?php

namespace App\Ship\Captain\Abstracts\Events\Jobs;

use App\Ship\Captain\Abstracts\Events\Interfaces\ShouldHandle;
use App\Ship\Captain\Abstracts\Jobs\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EventJob extends Job implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public ShouldHandle $handler
    ) {
    }

    public function handle(): void
    {
        $this->handler->handle();
    }
}
