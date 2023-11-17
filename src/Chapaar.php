<?php

namespace TookanTech\Chapaar;

use TookanTech\Chapaar\Contracts\DriverConnector;
use TookanTech\Chapaar\Contracts\DriverMessage;
use TookanTech\Chapaar\Enums\Drivers;

class Chapaar
{
    protected DriverConnector $driver;

    public function getDefaultSetting(): object
    {
        return $this->driver()::setting();
    }

    public function getDefaultDriver(): DriverConnector
    {
        $connector = Drivers::tryFrom(config('chapaar.default'))->connector();

        return new $connector;
    }

    public function send($message): object
    {
        return $this->driver($message->driver)->send($message);
    }

    public function verify(DriverMessage $message): object
    {
        return $this->driver($message->getDriver())->verify($message);
    }

    public function account(): object
    {

        return $this->driver()->account();
    }

    public function outbox(int $page_size = 100, int $page_number = 1): object
    {
        return $this->driver()->outbox($page_size, $page_number);
    }

    protected function driver(Drivers $driver = null): DriverConnector
    {
        $connector = $driver
        ? Drivers::tryFrom($driver->value)->connector()
        : Drivers::tryFrom(config('chapaar.default'))->connector();

        return new $connector;

    }
}
