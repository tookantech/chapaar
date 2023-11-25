<?php

namespace TookanTech\Chapaar\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Model;

class SmsMessage extends Model 
{

    protected $fillable = [
        'provider',
        'data',
        'status',
    ];

    protected $cast = [
        'data' => AsCollection::class
    ]
}
