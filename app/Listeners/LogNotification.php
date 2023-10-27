<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Events\NotificationSent;

class LogNotification
{
    public function handle(NotificationSent $event): void
    {
        Log::info('Sms Sent', ['notification' => $event->notification]);
    }
}
