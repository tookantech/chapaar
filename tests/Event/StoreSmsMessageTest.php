<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Symfony\Component\HttpFoundation\Response;
use TookanTech\Chapaar\Enums\Drivers;
use TookanTech\Chapaar\Events\SmsSent;
use TookanTech\Chapaar\Models\SmsMessage;

beforeEach(function () {
    $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations/');
    Artisan::call('migrate');
});
it('stores an sms message on sms sent event', function () {
    // Arrange: Create a mock response object as it would be passed to the event
    $response = new stdClass;
    $response->driver = Drivers::KAVENEGAR;
    $response->data = ['Message data'];
    $response->status = 'sent';

    // Mock the SmsSent event with the created response
    $event = new SmsSent($response);

    // Act: Dispatch the event
    Event::dispatch($event);

    // Assert: Check that a corresponding SmsMessage was stored in the database
    $this->assertDatabaseHas(SmsMessage::class, [
        'driver' => $response->driver,
        'status' => $response->status,
    ]);
});
