<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Exceptions\ApiException;
use Aryala7\Chapaar\Exceptions\HttpException;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class KavenegarConnector implements DriverConnector
{
    const PATH = '%s://api.kavenegar.com/v1/%s/%s/%s.json/';

    protected string $receptor = '';

    protected object $setting;

    protected $client;

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

    public function generatePath($method, $base = 'sms'): string
    {
        return sprintf(self::PATH, $this->setting->scheme, $this->setting->api_key, $base, $method);
    }

    public function setReceptor(array|string $receptor): static
    {
        if (is_array($receptor)) {
            $this->receptor = implode(',', $receptor);
        } else {
            $this->receptor = $receptor;
        }

        return $this;
    }

    public function send(DriverMessage $message)
    {
        $url = self::generatePath('sms');
        $this->setReceptor($message->to);
        $params = [
            'receptor' => $this->receptor,
            'message' => $message->content,
            'sender' => $message->from ?: $this->setting->line_number,
            'date' => $optionalTokens['date'] ?? null,
            'type' => $optionalTokens['type'] ?? null,
            'localid' => $optionalTokens['localid'] ?? null,
        ];

        return $this->performApi($url, $params);
    }

    public function verify(DriverMessage $message)
    {
        $url = self::generatePath('lookup', 'verify');
        $this->setReceptor($message->to);
        $params = [
            'receptor' => $this->receptor,
            'template' => $message->template,
            'token' => $message->tokens[0],
            'token2' => $message->tokens[1] ?? null,
            'token3' => $message->tokens[2] ?? null,
            'token10' => $message->tokens[3] ?? null,
            'token20' => $message->tokens[4] ?? null,
            'type' => $message->type ?? null,
        ];

        return $this->performApi($url, $params);
    }

    public function performApi(string $url, array $params)
    {
        $response = $this->client->post($url, [
            'form_params' => http_build_query($params),
        ]);

        return $this->processApiResponse($response);
    }

    protected function processApiResponse($response)
    {
        $status_code = $response->getStatusCode();
        $json_response = json_decode($response->getBody()->getContents());

        $this->validateResponseStatus($status_code, $json_response);

        return $json_response->entries;
    }

    protected function validateResponseStatus($status_code, $json_response)
    {
        if ($status_code !== Response::HTTP_OK) {
            throw new HttpException('Request has errors', $status_code);
        }

        if ($json_response === null) {
            throw new HttpException('Response is not valid JSON', $status_code);
        }

        if ($json_response->status !== Response::HTTP_OK) {
            throw new ApiException($json_response->return->message, $json_response->return->status);
        }
    }
}
