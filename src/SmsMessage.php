<?php

namespace TookanTech\Chapaar;

use TookanTech\Chapaar\Contracts\DriverMessage;
use TookanTech\Chapaar\Enums\Drivers;

class SmsMessage
{
    public function driver($driver = null): DriverMessage
    {
        $driver_message = $driver
        ? Drivers::tryFrom($driver->value)->message()
        : Drivers::tryFrom(config('chapaar.default'))->message();

        return new $driver_message;
    }
}
