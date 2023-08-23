<?php

namespace TookanTech\Chapaar;

use TookanTech\Chapaar\Contracts\DriverConnector;
use TookanTech\Chapaar\Contracts\DriverMessage;
use TookanTech\Chapaar\Enums\Drivers;

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

    public function send($message)
    {
        return $this->driver->send($message);
    }

    public function verify(DriverMessage $message)
    {
        return $this->driver->verify($message);
    }
}
