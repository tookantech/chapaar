<?php

namespace Aryala7\Chapaar\Exceptions;

class HttpException extends BaseException
{
    public function getName()
    {
        return 'HttpException';
    }
}
