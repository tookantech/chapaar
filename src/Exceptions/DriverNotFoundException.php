<?php

namespace Aryala7\Chapaar\Exceptions;

class DriverNotFoundException extends BaseException
{
    public function getName()
    {
        return 'DriverNotFoundException';
    }
}
