<?php

namespace TookanTech\Chapaar\Exceptions;

class DriverNotFoundException extends BaseException
{
    public function getName()
    {
        return 'DriverNotFoundException';
    }
}
