<?php

namespace Aryala7\Chapaar\Abstracts;

use Aryala7\Chapaar\Contracts\DriverConnector;

abstract class DriverSender
{
    abstract public function getDriver(): DriverConnector;

    public function send(array $args): void
    {
        $driver = $this->getDriver();
        $driver->send();
    }
}
