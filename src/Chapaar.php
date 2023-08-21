<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Enums\Drivers;

class Chapaar
{
    protected DriverConnector $driver;

    public function __construct()
    {
        $this->driver = $this->getDefaultDriver();
    }

    public function getDefaultDriver(): DriverConnector
    {

        $connector = Drivers::tryFrom(config('chapaar.default'))->connector();
        return new $connector;

    }

    public function send(DriverMessage $message)
    {
        return $this->driver->send($message);
    }

    public function verify(DriverMessage $message)
    {
        return $this->driver->verify($message);
    }
}
