<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Traits\HighPriorityMessage;
use App\Notifications\Channels\SmsChannel;

class OrderPaid extends CustomNotification
{
    use HighPriorityMessage;
    use Queueable;

    public int $tries = 1;
    public int $maxExceptions = 1;

    public function __construct(private readonly string $orderId)
    {
    }

    public function text(): string
    {
        return 'order.sms.order_paid_id_' . $this->orderId;
    }

    public function via(): string
    {
        return SmsChannel::class;
    }

    public function payload(object $notifiable): array
    {
        return [
            'to' => $notifiable->mobile,
            'message' => $this->text()
        ];
    }
}
