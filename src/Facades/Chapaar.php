<?php

namespace TookanTech\Chapaar\Facades;

use Illuminate\Support\Facades\Facade;
use TookanTech\Chapaar\Contracts\DriverConnector;

/**
 * @see \TookanTech\Chapaar\Chapaar
 *
 * @method DriverConnector send()
 * @method DriverConnector verify()
 */
class Chapaar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TookanTech\Chapaar\Chapaar::class;
    }
}
