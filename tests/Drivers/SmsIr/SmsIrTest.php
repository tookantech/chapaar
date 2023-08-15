<?php

use Aryala7\Chapaar\Drivers\SmsIr\SmsIrConnector;
use Aryala7\Chapaar\Drivers\SmsIr\SmsIrMessage;
use Aryala7\Chapaar\Exceptions\ApiException;
use GuzzleHttp\Psr7\Response as ApiResponse;
use Mockery as m;
use Symfony\Component\HttpFoundation\Response;

afterEach(fn () => m::close());

it('should select smsir based on config', function () {
    config()->set('chapaar.default', 'smsir');
    $driver = (new \Aryala7\Chapaar\SmsMessage())->driver();
    expect(get_class($driver))->toBe(SmsIrMessage::class);

});
it('can send plain message', function () {

    $expected_response = $this->generateResponse(Response::HTTP_OK, 'success');
    $mockedMessage = m::mock(SmsIrMessage::class);
    $connector = m::mock(SmsIrConnector::class);

    $connector->shouldReceive('send')->once()->with($mockedMessage)->andReturn($expected_response);
    $result = $connector->send($mockedMessage);
    expect($result)->toEqual($expected_response);

});

it('can send with template', function () {

    $expected_response = $this->generateResponse(Response::HTTP_OK, 'success');

    $mockedMessage = m::mock(SmsIrMessage::class);
    $connector = m::mock(SmsIrConnector::class);
    $connector->shouldReceive('verify')->with($mockedMessage)->once()->andReturn($expected_response);
    $result = $connector->verify($mockedMessage);
    expect($result)->toEqual($expected_response);
});

it('can return exception on empty body', function () {

    $mockedApiResponse = new ApiResponse(404, [], json_encode([]));

    $connector = m::mock(SmsIrConnector::class);
    $connector->shouldAllowMockingProtectedMethods();
    $connector->shouldReceive('processApiResponse')->once()->andThrow(
        new \Aryala7\Chapaar\Exceptions\HttpException('Response is not valid JSON', 404)
    );

    $connector->processApiResponse($mockedApiResponse);
})->throws(\Aryala7\Chapaar\Exceptions\HttpException::class, 'Response is not valid JSON', 404);

it('can return exception on not success status', function () {

    $mockedApiResponse = new ApiResponse(418, [], json_encode(['return' => [
        'status' => 418,
        'message' => 'Insufficient credit',
    ]]));

    $connector = m::mock(SmsIrConnector::class)->makePartial();
    $connector->shouldAllowMockingProtectedMethods();
    $connector->shouldReceive('processApiResponse')->once()->andThrow(
        new ApiException('Insufficient credit', 418)
    );

    $connector->processApiResponse($mockedApiResponse);
})->throws(ApiException::class, 'Insufficient credit', 418);
