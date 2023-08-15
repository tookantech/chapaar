<?php

namespace Aryala7\Chapaar\Tests\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TestUser extends Model
{
    use Notifiable;

    protected $table = 'users';

    public function routeNotificationForSms($driver, $notification = null)
    {
        return $this->cellphone;
    }
}
