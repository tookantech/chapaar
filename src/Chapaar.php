<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Drivers\SmsIr\SmsIr;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarConnector;
use Aryala7\Chapaar\Drivers\SmsIr\SmsIrConnector;

/**
 * @method getDefaultDriver
 */
class Chapaar
{
    public function getDefaultDriver()
    {
        return match(config('chapaar.default')){
            'kavenegar' => (new KavenegarConnector),
            'smsir'     => (new SmsIrConnector),
        };
    }

    public function send(DriverConnector $driver,DriverMessage $message)
    {
        return $driver->send($message);
    }
    public function verify(DriverConnector $driver,DriverMessage $message)
    {
        return $driver->verify($message);
    }
}
