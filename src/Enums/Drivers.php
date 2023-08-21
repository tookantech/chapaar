<?php

namespace TookanTech\Chapaar\Enums;

use TookanTech\Chapaar\Drivers\Ghasedak\GhasedakConnector;
use TookanTech\Chapaar\Drivers\Ghasedak\GhasedakMessage;
use TookanTech\Chapaar\Drivers\Kavenegar\KavenegarConnector;
use TookanTech\Chapaar\Drivers\Kavenegar\KavenegarMessage;
use TookanTech\Chapaar\Drivers\SmsIr\SmsIrConnector;
use TookanTech\Chapaar\Drivers\SmsIr\SmsIrMessage;

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
