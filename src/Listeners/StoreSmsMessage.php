<?php

namespace TookanTech\Chapaar\Events;

use TookanTech\Chapaar\Events\SmsSent;
use TookanTech\Chapaar\Models\SmsMessage;
use Illuminate\Contracts\Queue\ShouldQueue;


class StoreSmsMessage implements ShouldQueue
{
    public function handle(SmsSent $event)
    {
        $smsMessage = new SmsMessage();
        $smsMessage->provider = $event->provider;
        $smsMessage->recipient_number = $event->recipientNumber;
        $smsMessage->message = $event->message;
        $smsMessage->save();
    }
}