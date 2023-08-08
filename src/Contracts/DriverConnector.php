<?php

namespace Aryala7\Chapaar\Contracts;

interface DriverConnector
{
    public function performApi(string $url, array $params);

    public function send(DriverMessage $message);

    public function verify(DriverMessage $message);
}
