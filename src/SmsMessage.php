<?php

namespace Aryala7\Chapaar;

use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarMessage;
use Aryala7\Chapaar\Drivers\SmsIr\SmsIrMessage;

class SmsMessage implements DriverMessage
{
    
    public function __destruct()
    {

        return match (config('chapaar.default')) {
            'kavenegar' => KavenegarMessage::class,
            'smsir' => SmsIrMessage::class
        };
    }

    protected object $setting;

    protected string $driver = '';

    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * The phone number the message should be received to.
     *
     * @var string
     */
    public $to;

    /**
     * The verifing lookup template's name.
     *
     * @var string
     */
    public $template;

    public array $tokens = [];

    public function withTokens(array $tokens)
    {
        $this->tokens = $tokens;

        return $this;
    }

    public function template(string $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string  $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the phone number the message should be received to.
     *
     * @param  string  $to
     * @return $this
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }
}
