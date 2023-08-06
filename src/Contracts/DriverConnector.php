<?php

namespace Aryala7\Chapaar\Contracts;

interface DriverConnector
{
    public function send();

    public function setContent();

    public function setReceptors();
}
