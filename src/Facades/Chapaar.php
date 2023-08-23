<?php

namespace TookanTech\Chapaar\Facades;

use Illuminate\Support\Facades\Facade;
use TookanTech\Chapaar\Contracts\DriverConnector;

/**
 * @see \TookanTech\Chapaar\Chapaar
 *
 * @method DriverConnector send( $message)
 * @method DriverConnector verify( $message)
 */
class Chapaar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TookanTech\Chapaar\Chapaar::class;
    }
}
