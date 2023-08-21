<?php

namespace TookanTech\Chapaar\Exceptions;

class ApiException extends BaseException
{
    public function getName()
    {
        return 'ApiException';
    }
}
