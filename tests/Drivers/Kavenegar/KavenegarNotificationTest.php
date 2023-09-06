<?php

use Illuminate\Support\Facades\Notification;
use Mockery as m;
use TookanTech\Chapaar\SmsChannel;
use TookanTech\Chapaar\Tests\Database\Factories\UserFactory;
use TookanTech\Chapaar\Tests\Notifications\InvoicePaid;

beforeEach(fn () => config()->set('chapaar.default', 'kavenegar'));
afterEach(fn () => m::close());
it('can load custom notification channel', function () {
    $channel = Notification::channel('sms');
    expect(get_class($channel))->toBe(SmsChannel::class);
});
it('should send notification to the user', function () {

    $user = UserFactory::new()->create([
        'cellphone' => '09201111111',
    ]);
    Notification::fake();
    $user->notify(new InvoicePaid());
    Notification::assertSentTo($user, InvoicePaid::class);

    Notification::assertSentTimes(InvoicePaid::class, 1);

});

it('should return zero if parameters dont send correctly', function () {
    $notifiable = UserFactory::new()->create([
        'cellphone' => '09201111111',
    ]);
    $notification = new InvoicePaid();
    $channel = new SmsChannel();
    $response = $channel->send($notifiable, $notification);

    expect($response)->toBe(0);
});
