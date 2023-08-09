<?php

use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarConnector;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarMessage;
use GuzzleHttp\Psr7\Response;

it('can send plain message', function () {

    // Arrange
    $mockedApiResponse = new Response(200, [], json_encode(['return' => ['status' => 200]]));
    $mockedMessage = $this->getMockBuilder(KavenegarMessage::class)->getMock();

    $connector = $this->getMockBuilder(KavenegarConnector::class)
        ->onlyMethods(['performApi', 'generatePath'])
        ->getMock();

    $connector->method('performApi')->willReturn($mockedApiResponse);
    $connector->method('generatePath')->willReturn('mocked-path');

    // Act
    $result = $connector->send($mockedMessage);

    // Assert
    $this->assertSame(['return' => ['status' => 200]], json_decode($mockedApiResponse->getBody()->getContents(),true));

});

it('can send with template', function () {
    $mockedApiResponse = new Response(200, [], json_encode(['return' => ['status' => 200]]));
    $mockedMessage = $this->getMockBuilder(KavenegarMessage::class)->getMock();

    $mockedTokens = ['token1', 'token2'];
    $mockedMessage->expects($this->any())->method('getTokens')->willReturn($mockedTokens);
    $connector = $this->getMockBuilder(KavenegarConnector::class)
        ->onlyMethods(['performApi', 'generatePath'])
        ->getMock();

    $connector->method('performApi')->willReturn($mockedApiResponse);
    $connector->method('generatePath')->willReturn('mocked-path');

    // Act
    $result = $connector->verify($mockedMessage);

    // Assert
    $this->assertSame(['return' => ['status' => 200]], json_decode($mockedApiResponse->getBody()->getContents(),true));
});
