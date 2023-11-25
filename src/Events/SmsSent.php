<?php

namespace TookanTech\Chapaar\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SmsSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $provider;
    public $data;
    public $status;

    public function __construct($provider, $data, $status)
    {
        $this->provider = $provider;
        $this->data = $data;
        $this->status = $status;
    }
}
