<?php

namespace App\Notifications\Drivers;

use Illuminate\Support\Facades\Log;

class SecondDriver extends Driver
{
    public function sendMessage(array $notification): void
    {
        Log::info('Sending Sms Message',
            [
                'provider' => self::class,
                'to' => $notification['to'],
                'message' => $notification['message']
            ]
        );
    }

    public function fallbackDriver(): string
    {
        return ThirdDriver::class;
    }
}
