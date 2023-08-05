<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Abstracts\DriverSender;

class Chapaar
{
    public function handle(DriverSender $driver)
    {
        $driver->send([]);
    }
}
