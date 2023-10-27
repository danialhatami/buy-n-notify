<?php

namespace App\Notifications;

use App\Notifications\Drivers\Driver;
use Illuminate\Notifications\Notification;

abstract class CustomNotification extends Notification
{
    abstract public function driver(): Driver;

    abstract public function text(): string;

    public function payload(object $notifiable): array
    {
        return [
            'to' => $notifiable->mobile,
            'message' => $this->text()
        ];
    }
}
