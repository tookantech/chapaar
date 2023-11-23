<?php

namespace TookanTech\Chapaar\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SmsSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $provider;

    public $recipientNumber;

    public $message;

    public function __construct($provider, $recipientNumber, $message)
    {
        $this->provider = $provider;
        $this->recipientNumber = $recipientNumber;
        $this->message = $message;
    }
}
