<?php

namespace Aryala7\Chapaar\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aryala7\Chapaar\Chapaar
 *
 * @method handle
 */
class Chapaar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aryala7\Chapaar\Chapaar::class;
    }
}
