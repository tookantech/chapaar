<?php

namespace Aryala7\Chapaar\Contracts;

use Aryala7\Chapaar\SmsMessage;

interface DriverConnector
{
    public function performApi(string $url, array $params);

    public function send($message);
//
    public function verify($message);
}
