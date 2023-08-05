<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\Abstracts\DriverSender;
use Aryala7\Chapaar\Contracts\DriverConnector;

class KavenegarSender extends DriverSender
{
    public function send(array $args): void
    {
        // TODO: Implement send() method.
    }

    public function getDriver(): DriverConnector
    {
        return new KavenegarConnector();
    }
}
