<?php

use TookanTech\Chapaar\Drivers\SmsIr\SmsIrConnector;
use TookanTech\Chapaar\Drivers\SmsIr\SmsIrMessage;
use TookanTech\Chapaar\Exceptions\ApiException;
use GuzzleHttp\Psr7\Response as ApiResponse;
use Mockery as m;
use Symfony\Component\HttpFoundation\Response;

beforeEach(fn() => config()->set('chapaar.default', 'smsir'));
afterEach(fn () => m::close());
it('can generate endpoint', function () {
    $endpoint = (new SmsIrConnector())::endpoint('send','sms');
    expect($endpoint)->toBe("https://api.sms.ir/v1/send/sms");
});
it('should select smsir based on config', function () {
    config()->set('chapaar.default', 'smsir');
    $driver = (new \TookanTech\Chapaar\SmsMessage())->driver();
    expect(get_class($driver))->toBe(SmsIrMessage::class);

});
it('can send plain message', function () {

    $expected_response = $this->generateResponse(Response::HTTP_OK, 'success');
    $mockedMessage = m::mock(SmsIrMessage::class);
    $connector = m::mock(SmsIrConnector::class);

    $connector->shouldReceive('send')->once()->with($mockedMessage)->andReturn($expected_response);
    $connector->shouldReceive('endpoint')->with('path')->andReturn('path_response');
    $connector->shouldReceive('performApi')->with('path_response', m::type('array'))->andReturn($expected_response);
    $result = $connector->send($mockedMessage);
    expect($result)->toEqual($expected_response);

});

it('can send with template', function () {

    $expected_data = [
        'status' => 1,
        'message' => 'موفق',
        'data' => [
            [
                'messageId' => 89545112,
                'cost' => 1.0,
            ],
        ],
    ];
    $expected_response = $this->generateResponse(1, 'success',$expected_data);

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
        new \TookanTech\Chapaar\Exceptions\HttpException('Response is not valid JSON', 404)
    );

    $connector->processApiResponse($mockedApiResponse);
})->throws(\TookanTech\Chapaar\Exceptions\HttpException::class, 'Response is not valid JSON', 404);

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
