<?php

namespace TookanTech\Chapaar\Models;

use Illuminate\Database\Eloquent\Model;

class SmsMessage extends Model
{
    protected $fillable = [
        'provider',
        'recipient_number',
        'message',
    ];
}
