<?php

namespace Aryala7\Chapaar\Drivers\SmsIr;

use Aryala7\Chapaar\Contracts\DriverConnector;
use Aryala7\Chapaar\Contracts\DriverMessage;
use Aryala7\Chapaar\Exceptions\ApiException;
use Aryala7\Chapaar\Exceptions\HttpException;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class SmsIrConnector implements DriverConnector
{
    const PATH = 'https://api.sms.ir/%s/%s/%s';

    protected array|string $receptor = '';

    protected object $setting;

    protected $client;

    protected string $content = '';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::PATH,
            'headers' => [
                'X-API-KEY' => config('chapaar.drivers.smsir.api_key'),
                'ACCEPT' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);
        $this->setting = (object) config('chapaar.drivers.smsir');
    }

    public function generatePath($method, $base = 'send'): string
    {
        return sprintf(self::PATH, $this->setting->version, $base, $method);
    }

    public function setReceptor(array|string $receptor): static
    {
        $this->receptor = is_array($receptor) ?: [$receptor];

        return $this;
    }

    public function getReceptor()
    {
        return $this->receptor;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    public function send(DriverMessage $message)
    {
        $url = self::generatePath('bulk');
        $this->setReceptor($message->to);
        $params = [
            'lineNumber' => $message->from ?: $this->setting->line_number,
            'MessageText' => $message->content,
            'Mobiles' => $this->getReceptor(),
            'SendDateTime' => $message->dateTime ?? null,
        ];

        return $this->performApi($url, $params);
    }

    public function verify(DriverMessage $message)
    {
        $url = self::generatePath('verify');
        $params = [
            'Mobile' => $message->to,
            'TemplateId' => $message->template,
            'Parameters' => $message->tokens,
        ];

        return $this->performApi($url, $params);

    }

    public function performApi(string $url, array $params)
    {
        $response = $this->client->post($url, $params);

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

        if ($json_response->status !== 1) {
            throw new ApiException($json_response->return->message, $json_response->return->status);
        }
    }
}
