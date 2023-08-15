<?php

namespace Aryala7\Chapaar\Drivers\SmsIr;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Exceptions\ApiException;
use Aryala7\Chapaar\Exceptions\HttpException;
use Aryala7\Chapaar\Traits\HasResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SmsIrConnector implements DriverConnector
{
    use HasResponse;

    protected object $setting;

    protected Client $client;


    public function __construct()
    {
        $this->setting = (object) config('chapaar.drivers.smsir');
        $this->client = new Client([
            'headers' => [
                'x-api-key' => $this->setting->api_key,
                'Accept' => 'text/plain',
                'Content-Type' => 'application/json',
            ],
        ]);

    }

    public function generatePath($method, string $base = 'send'): string
    {
        return sprintf($this->setting->url, $this->setting->version, $base, $method);
    }

    /**
     * @param  SmsIrMessage  $message
     *
     * @throws GuzzleException
     */
    public function send($message): object
    {
        $url = self::generatePath('bulk');
        $params = [
            'lineNumber' => $message->getFrom() ?: $this->setting->line_number,
            'MessageText' => $message->getContent(),
            'Mobiles' => $message->getTo(),
            'SendDateTime' => $message->dateTime ?? null,
        ];

        return $this->performApi($url, $params);
    }

    /**
     * @param  SmsIrMessage  $message
     *
     * @throws GuzzleException
     */
    public function verify($message): object
    {
        $url = self::generatePath('verify');
        $params = [
            'mobile' => $message->getTo(),
            'templateId' => (int) $message->getTemplate(),
            'parameters' => $message->getTokens(),
        ];

        return $this->performApi($url, $params);

    }

    /**
     * @throws GuzzleException
     */
    public function performApi(string $url, array $params): object
    {
        $response = $this->client->post($url, [
            'json' => $params,
        ]);

        return $this->processApiResponse($response);
    }

    protected function processApiResponse($response): object
    {
        $status_code = $response->getStatusCode();
        $json_response = json_decode($response->getBody()->getContents());
        $this->validateResponseStatus($status_code, $json_response);

        return $this->generateResponse($json_response->status, $json_response?->message, (array) $json_response?->data);
    }

    protected function validateResponseStatus($status_code, $json_response): void
    {
        if ($json_response === null) {
            throw new HttpException('Response is not valid JSON', $status_code);
        }

        if ($json_response->status !== 1) {
            throw new ApiException($json_response->message, $json_response->status);
        }
    }
}
