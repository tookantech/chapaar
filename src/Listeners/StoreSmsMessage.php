<?php

namespace TookanTech\Chapaar\Listeners;

use TookanTech\Chapaar\Models\SmsMessage;
use TookanTech\Chapaar\Events\SmsSent;
class StoreSmsMessage
{

    public function handle(SmsSent $event)
    {

        $response = $event->response;
        $smsMessage = new SmsMessage();
        $smsMessage->driver = $response->driver;
        $smsMessage->data = $response->data;
        $smsMessage->status = $response->status;
        $smsMessage->save();
    }
}
