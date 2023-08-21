<?php

namespace TookanTech\Chapaar;

use TookanTech\Chapaar\Contracts\DriverMessage;
use TookanTech\Chapaar\Enums\Drivers;

class SmsMessage
{
    protected string $message_driver;

    protected DriverMessage $driver;

    public function __construct()
    {
        $this->message_driver = Drivers::tryFrom(config('chapaar.default'))->message();
    }

    public function driver(): DriverMessage
    {
        return new $this->message_driver;
    }
}
