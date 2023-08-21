<?php

namespace TookanTech\Chapaar\Exceptions;

class HttpException extends BaseException
{
    public function getName()
    {
        return 'HttpException';
    }
}
