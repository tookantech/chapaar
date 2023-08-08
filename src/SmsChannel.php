<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Facades\Chapaar;

class SmsChannel
{
    protected object $setting;
    protected DriverConnector $driver;
    protected DriverMessage $message;

    public function __construct()
    {
        $this->driver = Chapaar::getDefaultDriver();
        $this->setting = config('chapaar.drivers.'.$this->driver);    
    }
    public function send($notifiable, $notification)
    {        

        $message = $notification->toSms($notifiable);
        $message->to($message->to ?: $notifiable->routeNotificationFor('sms', $notification));
        if (!$message->to || !($message->from || $message->template)) {
            return;
        }
        $message->template ?
         $this->driver->verify($message) :
         $this->driver->send($message);
        return $this->driver->send($message);
    }
    
}
