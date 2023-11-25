<?php

namespace TookanTech\Chapaar\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use TookanTech\Chapaar\Contracts\DriverMessage;

class SmsSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;

    public function __construct($response)
    {
        $this->response = $response;
    }
}
