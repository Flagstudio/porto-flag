<?php

namespace App\Ship\Parents\Events;

use App\Ship\Captain\Abstracts\Events\Event as AbstractEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class Event extends AbstractEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
}
