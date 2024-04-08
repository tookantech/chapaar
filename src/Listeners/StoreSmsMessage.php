<?php

namespace TookanTech\Chapaar\Listeners;

use TookanTech\Chapaar\Events\SmsSent;
use TookanTech\Chapaar\Models\SmsMessage;

class StoreSmsMessage
{
    public function handle(SmsSent $event): void
    {

        $response = $event->response;
        $smsMessage = new SmsMessage();
        $smsMessage->driver = $response->driver;
        $smsMessage->data = $response->data;
        $smsMessage->status = $response->status;
        $smsMessage->save();
    }
}
