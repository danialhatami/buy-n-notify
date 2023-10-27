<?php

namespace App\Notifications\Channels;

use App\Notifications\CustomNotification;

class SmsChannel
{
    /**
     * @throws \Exception
     */
    public function send(object $notifiable, CustomNotification $notification): void
    {
        $message = $notification->payload($notifiable);
        $notification->driver()->send($message);
    }
}
