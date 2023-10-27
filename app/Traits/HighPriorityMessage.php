<?php

namespace App\Traits;

use App\Notifications\Drivers\Driver;
use App\Notifications\Drivers\FirstDriver;

trait HighPriorityMessage
{
    public function driver(): Driver
    {
        return app(FirstDriver::class);
    }
}
