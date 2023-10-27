<?php

namespace App\Notifications\Drivers;

class FirstDriver extends Driver
{
    public function sendMessage(array $notification): void
    {
        throw new \Exception();
    }

    public function fallbackDriver(): string
    {
        return SecondDriver::class;
    }
}
