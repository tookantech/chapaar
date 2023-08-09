<?php

namespace Aryala7\Chapaar\Drivers\SmsIr;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Drivers\Kavenegar\KavenegarMessage;
use Aryala7\Chapaar\Exceptions\ApiException;
use Aryala7\Chapaar\Exceptions\HttpException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

class SmsIrConnector implements DriverConnector
{

    protected array|string $receptor = '';

    protected object $setting;

    protected Client $client;

    protected string $content = '';

    public function __construct()
    {
        $this->setting = (object) config('chapaar.drivers.smsir');
        $this->client = new Client([
            'base_uri' => $this->setting->url,
            'headers' => [
                'X-API-KEY' => $this->setting->api_key,
                'ACCEPT' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

    }

    /**
     * @param $method
     * @param string $base
     * @return string
     */
    public function generatePath($method, string $base = 'send'): string
    {
        return sprintf($this->setting->url, $this->setting->version, $base, $method);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }


    /**
     * @param SmsIrMessage $message
     * @return object
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
     * @param SmsIrMessage $message
     * @return object
     * @throws GuzzleException
     */
    public function verify($message):object
    {
        $url = self::generatePath('verify');
        $params = [
            'Mobile' => $message->getTo(),
            'TemplateId' => $message->getTemplate(),
            'Parameters' => $message->getTokens(),
        ];

        return $this->performApi($url, $params);

    }


    /**
     * @param string $url
     * @param array $params
     * @return object
     * @throws GuzzleException
     */
    public function performApi(string $url, array $params): object
    {
        $response = $this->client->post($url, $params);

        return $this->processApiResponse($response);
    }

    /**
     * @param $response
     * @return object
     */
    protected function processApiResponse($response): object
    {
        $status_code = $response->getStatusCode();
        $json_response = json_decode($response->getBody()->getContents());

        $this->validateResponseStatus($status_code, $json_response);

        return $json_response->entries;
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

        if ($json_response->status !== 1) {
            throw new ApiException($json_response->return->message, $json_response->return->status);
        }
    }
}
