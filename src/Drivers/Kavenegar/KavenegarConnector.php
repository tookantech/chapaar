<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\Contracts\DriverConnector;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class KavenegarConnector implements DriverConnector
{
    const PATH = '%s://api.kavenegar.com/v1/%s/%s/%s.json/';

    protected array|string $receptor = '';

    protected object $setting;

    protected $client;

    protected string $content = '';

    public function __construct()
    {
        $this->client = (new Client());
        $this->setting = (object) config('chapaar.drivers.kavenegar');
    }

    public function generatePath($base = 'sms'): string
    {
        return sprintf(self::PATH, $this->setting->scheme, $this->setting->api_key, $base, $this->setting->method);

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

    public function send()
    {
        $url = self::generatePath();
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'charset' => 'utf-8',
        ])->send($this->setting->method, $url, [
            'body' => http_build_query($this->prepareData()),
            'http_errors' => false,
        ]);
        $result = $response->body();
        if (! $response->successful()) {
            return $result; //todo:handle exception
        }

        return $result;

    }

    public function prepareData(): array
    {
        return [
            'receptor' => $this->getReceptor(),
            'message' => $this->getContent(),
            'sender' => $this->setting->line_number,
            'date' => null,
            'type' => null,
            'local' => null,
            //            'hide' => ''
        ];
    }
}
