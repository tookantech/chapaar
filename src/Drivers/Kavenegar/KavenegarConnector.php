<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Exceptions\ApiException;
use Aryala7\Chapaar\Exceptions\HttpException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class KavenegarConnector implements DriverConnector
{
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

    /**
     * @param $method
     * @param string $base
     * @return string
     */
    public function generatePath($method, string $base = 'sms'): string
    {
        return sprintf($this->setting->url, $this->setting->scheme, $this->setting->api_key, $base, $method);
    }


    /**
     * @param KavenegarMessage $message
     * @return object
     * @throws GuzzleException
     */
    public function send($message): object
    {
        $url = $this->generatePath('send');
        $params = [
            'receptor' => $message->getTo(),
            'message' => $message->getContent(),
            'sender' => $message->getFrom() ?: $this->setting->line_number,
            'date' => $message->getDate() ?? NULL,
            'type' => $message->getType() ?? NULL,
            'localid' => $message->getLocalId() ?? NULL,
        ];

        return $this->performApi($url, $params);
    }

    /**
     * @param  KavenegarMessage $message
     * @return object
     * @throws GuzzleException
     */
    public function verify($message): object
    {
        $url = $this->generatePath('lookup', 'verify');
        $params = [
            'receptor' => $message->getTo(),
            'template' => $message->getTemplate(),
            'token' => $message->getTokens()[0],
            'token2' => $message->getTokens()[1] ?? NULL,
            'token3' => $message->getTokens()[2] ?? NULL,
            'token10' => $message->getTokens()[3] ?? NULL,
            'token20' => $message->getTokens()[4] ?? NULL,
            'type' => $message->getType() ?? NULL,
        ];

        return $this->performApi($url, $params);
    }

    /**
     * @param string $url
     * @param array $params
     * @return object
     * @throws GuzzleException
     */
    public function performApi(string $url, array $params):object
    {
        $response = $this->client->post($url, [
            'form_params' => $params,
        ]);
        return $this->processApiResponse($response);
    }

    /**
     * @param $response
     * @return object
     */
    protected function processApiResponse($response):object
    {
        $status_code = $response->getStatusCode();
        $json_response = json_decode($response->getBody()->getContents());

        $this->validateResponseStatus($status_code, $json_response);

        return $json_response->return;
    }

    /**
     * @param $status_code
     * @param $json_response
     * @return void
     */
    protected function validateResponseStatus($status_code, $json_response): void
    {
        if ($status_code !== Response::HTTP_OK) {
            throw new HttpException('Request has errors', $status_code);
        }

        if ($json_response === null) {
            throw new HttpException('Response is not valid JSON', $status_code);
        }

        if ($json_response->return->status !== Response::HTTP_OK) {
            throw new ApiException($json_response->return->message, $json_response->return->status);
        }
    }
}
