<?php

namespace Aryala7\Chapaar\Drivers\Ghasedak;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Exceptions\ApiException;
use Aryala7\Chapaar\Exceptions\HttpException;
use Aryala7\Chapaar\Traits\HasResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;

class GhasedakConnector implements DriverConnector
{
    use HasResponse;

    protected object $setting;

    protected Client $client;

    protected string $content = '';

    public function __construct()
    {
        $this->setting = (object) config('chapaar.drivers.ghasedak');
        $this->client = new Client([
            'headers' => [
                'apikey' => $this->setting->api_key,
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'charset: utf-8',
            ],
        ]);

    }

    public function generatePath($base, $action, $method): string
    {
        return sprintf($this->setting->url, $this->setting->version, $base, $action, $method);
    }

    /**
     * @param  GhasedakMessage  $message
     *
     * @throws GuzzleException
     */
    public function send($message): object
    {
        $url = self::generatePath('sms', 'send', 'simple');
        $params = [
            'linenumber' => $message->getFrom() ?: $this->setting->line_number,
            'message' => $message->getContent(),
            'receptor' => $message->getTo(),
            'checkid' => $message->dateTime ?? null,
        ];

        return $this->performApi($url, $params);
    }

    /**
     * @param  GhasedakMessage  $message
     *
     * @throws GuzzleException
     */
    public function verify($message): object
    {
        $url = self::generatePath('verification', 'send', 'simple');
        $params = [
            'receptor' => $message->getTo(),
            'type' => $message->getType(),
            'template' => (int) $message->getTemplate(),
            ...array_map(fn ($key, $arg) => ["param$key" => $arg], // param1,param2,...
                array_keys($message->getTokens()), $message->getTokens()
            ),

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

        return $this->generateResponse($json_response->status, $json_response?->message, (array) $json_response?->data);
    }

    protected function validateResponseStatus($status_code, $json_response): void
    {
        if ($json_response === null) {
            throw new HttpException('Response is not valid JSON', $status_code);
        }

        if ($json_response->status !== Response::HTTP_OK) {
            throw new ApiException($json_response->message, $json_response->status);
        }
    }
}
