<?php

namespace Aryala7\Chapaar\Enums;

use Aryala7\Chapaar\Drivers\Ghasedak\GhasedakConnector;
use Aryala7\Chapaar\Drivers\Ghasedak\GhasedakMessage;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarConnector;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarMessage;
use Aryala7\Chapaar\Drivers\SmsIr\SmsIrConnector;
use Aryala7\Chapaar\Drivers\SmsIr\SmsIrMessage;

enum Drivers:string
{
    case KAVENEGAR = 'kavenegar';
    case SMSIR = 'smsir';
    case GHASEDAK = 'ghasedak';

    public function connector():string
    {
        return match ($this) {
            self::KAVENEGAR      => KavenegarConnector::class,
            self::SMSIR          => SmsIrConnector::class,
            self::GHASEDAK       => GhasedakConnector::class,
        };
    }
    public function message():string
    {
        return match ($this) {
            self::KAVENEGAR      => KavenegarMessage::class,
            self::SMSIR          => SmsIrMessage::class,
            self::GHASEDAK       => GhasedakMessage::class,
        };
    }

}
