<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Illuminate\Notifications\Notification;

class KavenegarChannel
{
    protected $api;

    /**
     * KavenegarChannel constructor.
     */
    public function __construct(KavenegarConnector $api)
    {
        $this->api = $api;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $receptor = $notifiable->routeNotificationFor('kavenegar');
        $content = $notification->toKavenegar($notifiable);

        $this->api
            ->setReceptor($receptor)
            ->setContent($content)
            ->send();
    }
}
