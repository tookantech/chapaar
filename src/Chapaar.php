<?php

namespace TookanTech\Chapaar;

use TookanTech\Chapaar\Contracts\DriverConnector;
use TookanTech\Chapaar\Contracts\DriverMessage;
use TookanTech\Chapaar\Enums\Drivers;
use TookanTech\Chapaar\Events\SmsSent;

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
        $response = $this->driver($message->getDriver())->send($message);

        SmsSent::dispatchIf(self::shouldStoreToSentMessage(), $response);

        return $response;

    }

    public function verify(DriverMessage $message): object
    {
        $response = $this->driver($message->getDriver())->verify($message);

        SmsSent::dispatchIf(self::shouldStoreToSentMessage(), $response);

        return $response;
    }

    public function account(): object
    {

        return $this->driver()->account();
    }

    public function outbox(int $page_size = 100, int $page_number = 1): object
    {
        return $this->driver()->outbox($page_size, $page_number);
    }

    protected function driver(?Drivers $driver = null): DriverConnector
    {
        if (is_null($driver)) {
            $driver = Drivers::from(config('chapaar.default'));
        }

        return new ($driver->connector());
    }

    protected static function shouldStoreToSentMessage(): bool
    {
        return config('chapaar.status');
    }
}
