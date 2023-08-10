<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Exceptions\ApiException;
use Aryala7\Chapaar\Exceptions\HttpException;
use Aryala7\Chapaar\Traits\HasResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class KavenegarConnector implements DriverConnector
{
    use HasResponse;
    protected object $setting;

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
        $this->setting = (object) config('chapaar.drivers.kavenegar');
    }

    public function generatePath($method, string $base = 'sms'): string
    {
        return sprintf($this->setting->url, $this->setting->scheme, $this->setting->api_key, $base, $method);
    }

    /**
     * @param  KavenegarMessage  $message
     *
     * @throws GuzzleException
     */
    public function send($message): object
    {
        $url = $this->generatePath('send');
        $params = [
            'receptor' => $message->getTo(),
            'message' => $message->getContent(),
            'sender' => $message->getFrom() ?: $this->setting->line_number,
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
        $url = $this->generatePath('lookup', 'verify');
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
    public function performApi(string $url, array $params): object
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

        return  $this->generateResponse($json_response->return?->status,$json_response->return?->message,(array)$json_response?->entries);

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
