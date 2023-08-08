<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\SmsMessage;

/*
 * @method setTemplate
 */
class KavenegarMessage extends SmsMessage
{
    /**
     * The message type.
     *
     * @var string
     */
    public $type = 'text';

    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }
}
