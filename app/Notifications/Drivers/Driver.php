<?php

namespace App\Notifications\Drivers;

abstract class Driver
{
    abstract public function sendMessage(array $notification);

    abstract public function fallbackDriver(): string;

    final public function send(array $notification): void
    {
        try {
            $this->sendMessage($notification);
        } catch (\Exception $exception) {
            try {
                app($this->fallbackDriver())->sendMessage($notification);
            } catch (\Exception $exception) {
                throw new \Exception("Primary and Fallback sms drivers failed.");
            }
        }
    }
}
