<?php

namespace TookanTech\Chapaar;

use TookanTech\Chapaar\Contracts\DriverConnector;
use TookanTech\Chapaar\Contracts\DriverMessage;
use TookanTech\Chapaar\Enums\Drivers;

class SmsChannel
{
    protected DriverConnector $driver;

    protected DriverMessage $message;

    public function send($notifiable, $notification)
    {

        /** @var DriverMessage $message */
        $message = $notification->toSms($notifiable);

        $recipient = $message->getTo() ?: $notifiable->routeNotificationFor('sms', $notification);
        $message->setTo($recipient);
        $template = $message->getTemplate();
        if (! $recipient || ! ($message->getFrom() || $message->getTemplate())) {
            return 0;
        }
        if ($template) {
            return $this->driver($message->getDriver())->verify($message);
        } else {
            return $this->driver($message->getDriver())->send($message);
        }

    }

    protected function driver(?Drivers $driver = null): DriverConnector
    {
        $connector = $driver
        ? Drivers::tryFrom($driver->value)->connector()
        : Drivers::tryFrom(config('chapaar.default'))->connector();

        return new $connector;

    }
}
