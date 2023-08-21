<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Enums\Drivers;

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
