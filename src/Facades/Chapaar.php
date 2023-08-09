<?php

namespace Aryala7\Chapaar\Facades;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Aryala7\Chapaar\Chapaar
 *
 * @method DriverConnector send()
 * @method DriverConnector verify()
 */
class Chapaar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aryala7\Chapaar\Chapaar::class;
    }
}
