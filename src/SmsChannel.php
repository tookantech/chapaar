<?php

namespace TookanTech\Chapaar;

use TookanTech\Chapaar\Contracts\DriverConnector;
use TookanTech\Chapaar\Contracts\DriverMessage;
use TookanTech\Chapaar\Facades\Chapaar;

class SmsChannel
{
    protected DriverConnector $driver;

    protected DriverMessage $message;


    public function send($notifiable, $notification)
    {

        /** @var DriverMessage $message */
        $message = $notification->toSms($notifiable);

        $recipient = $message->getTo() ?: $notifiable->routeNotificationFor('sms', $notification);
        $template = $message->getTemplate();
        if (! $recipient || ! ($message->getFrom() || $message->getTemplate())) {
            return 0;
        }
        if ($template) {
            return $this->driver->verify($message);
        } else {
            return $this->driver->send($message);
        }

    }
}
