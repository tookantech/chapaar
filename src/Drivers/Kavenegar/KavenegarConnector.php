<?php

namespace TookanTech\Chapaar\Drivers\Kavenegar;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;
use TookanTech\Chapaar\Contracts\DriverConnector;
use TookanTech\Chapaar\Exceptions\ApiException;
use TookanTech\Chapaar\Exceptions\HttpException;
use TookanTech\Chapaar\Traits\HasResponse;

class KavenegarConnector implements DriverConnector
{
    use HasResponse;

    protected static object $setting;

    protected Client $client;

    public function __construct()
    {
        $this->client = (new Client([
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'charset' => 'utf-8',
            ],
            'verify' => false,
            'http_errors' => false,
        ]));
        self::$setting = (object) config('chapaar.drivers.kavenegar');
    }

    /**
     * @param  KavenegarMessage  $message
     *
     * @throws GuzzleException
     */
    public function send($message): object
    {
        $url = self::endpoint('sms', 'send.json');
        $params = [
            'receptor' => $message->getTo(),
            'message' => $message->getContent(),
            'sender' => $message->getFrom() ?: self::$setting->line_number,
            'date' => $message->getDate() ?? null,
            'type' => $message->getType() ?? null,
            'localid' => $message->getLocalId() ?? null,
        ];

        return $this->performApi($url, $params);
    }

    /**
     * @param  KavenegarMessage  $message
     *
     * @throws GuzzleException
     */
    public function verify($message): object
    {
        $url = self::endpoint('verify', 'lookup.json');
        $params = [
            'receptor' => $message->getTo(),
            'template' => $message->getTemplate(),
            'token' => $message->getTokens()[0],
            'token2' => $message->getTokens()[1] ?? null,
            'token3' => $message->getTokens()[2] ?? null,
            'token10' => $message->getTokens()[3] ?? null,
            'token20' => $message->getTokens()[4] ?? null,
            'type' => $message->getType() ?? null,
        ];

        return $this->performApi($url, $params);
    }

    /**
     * @throws GuzzleException
     */
    public function account(): object
    {
        $url = self::endpoint('account', 'info.json');

        return $this->performApi($url);
    }

    /**
     * @throws GuzzleException
     */
    public function performApi(string $url, array $params = []): object
    {
        $response = $this->client->post($url, [
            'form_params' => $params,
        ]);

        return $this->processApiResponse($response);
    }

    protected function processApiResponse($response): object
    {
        $status_code = $response->getStatusCode();
        $json_response = json_decode($response->getBody()->getContents());

        $this->validateResponseStatus($status_code, $json_response);

        return $this->generateResponse($json_response->return?->status, $json_response->return?->message, (array) $json_response?->entries);

    }

    protected function validateResponseStatus($status_code, $json_response): void
    {
        if ($json_response === null) {
            throw new HttpException('Response is not valid JSON', $status_code);
        }
        if ($json_response->return?->status !== Response::HTTP_OK) {
            throw new ApiException($json_response->return->message, $json_response->return->status);
        }
    }
}
