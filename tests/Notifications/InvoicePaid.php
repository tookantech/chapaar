<?php

namespace Aryala7\Chapaar\Tests\Notifications;

use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\SmsMessage;
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
