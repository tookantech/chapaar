<?php

namespace TookanTech\Chapaar\Tests\Notifications;

use TookanTech\Chapaar\Contracts\DriverMessage;
use TookanTech\Chapaar\SmsMessage;
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    public function via($notifiable): array
    {
        return ['sms'];
    }

    public function toSms($notifiable): DriverMessage
    {

        return (new SmsMessage)
            ->driver()
            ->setTokens([
                '123',
                '456',
            ]);
    }
}
