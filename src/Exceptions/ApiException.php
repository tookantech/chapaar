<?php

namespace Aryala7\Chapaar\Exceptions;

class ApiException extends BaseException
{
    public function getName()
    {
        return 'ApiException';
    }
}
