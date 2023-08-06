<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\Abstracts\DriverSender;
use Aryala7\Chapaar\Contracts\DriverConnector;

class KavenegarSender extends DriverSender
{
    protected string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getDriver(): DriverConnector
    {
        return new KavenegarConnector($this->content);
    }
}
