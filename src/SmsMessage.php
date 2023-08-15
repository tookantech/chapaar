<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Drivers\Ghasedak\GhasedakMessage;
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
            'ghasedak' => GhasedakMessage::class,
            default => function () {
                throw new DriverNotFoundException('Unknown Driver'.config('chapaar.default'));
            }
        };
    }

    public function driver(): DriverMessage
    {
        return new $this->message_driver;
    }
}
