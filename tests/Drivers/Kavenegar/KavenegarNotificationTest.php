<?php

use Aryala7\Chapaar\Tests\Database\Factories\UserFactory;
use Aryala7\Chapaar\Tests\Notifications\InvoicePaid;
use Mockery as m;
use Illuminate\Support\Facades\Notification;

afterEach(fn () => m::close());
it('should send notification to the user', function () {
    $user = UserFactory::new()->create([
        'cellphone' => '09201111111'
    ]);
    Notification::fake();
    $user->notify(new InvoicePaid());
    Notification::assertSentTo($user, InvoicePaid::class);

});


it('should return zero if parameters dont send correctly', function () {
    $notifiable = UserFactory::new()->create([
        'cellphone' => '09201111111'
    ]);
    $notification = new InvoicePaid();
    $channel = new \Aryala7\Chapaar\SmsChannel();
    $response = $channel->send($notifiable, $notification);

    expect($response)->toBe(0);
});
