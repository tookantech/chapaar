<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;
use Illuminate\Notifications\Notification;
class KavenegarChannel
{
    protected $api;

    /**
     * KavenegarChannel constructor.
     * @param KavenegarConnector $api
     */
    public function __construct(KavenegarConnector $api)
    {
        $this->api = $api;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param Notification $notification
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
