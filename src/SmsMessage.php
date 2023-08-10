<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarMessage;
use Aryala7\Chapaar\Drivers\SmsIr\SmsIrMessage;
use Aryala7\Chapaar\Exceptions\DriverNotFoundException;

class SmsMessage
{
    protected string $message_driver;

    protected DriverMessage $driver;

    public function __construct()
    {

        $default_driver = config('chapaar.default');
        $this->message_driver = match ($default_driver) {
            'kavenegar' => KavenegarMessage::class,
            'smsir' => SmsIrMessage::class,
            default => function () {
                throw new DriverNotFoundException('Unknown Driver'.config('chapaar.default'));
            }
        };
    }
    
    public function driver()
    {
        return new $this->message_driver;
    }
}
