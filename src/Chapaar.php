<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Abstracts\DriverSender;
use Aryala7\Chapaar\Contracts\DriverConnector;

class Chapaar
{
    public array $data = [];
    protected DriverConnector $via;

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }
    public function handle(DriverSender $sender): void
    {
        dd($sender);
        $sender->send($this->getData());
    }

}
