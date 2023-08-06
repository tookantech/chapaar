<?php

namespace Aryala7\Chapaar\Drivers\Kavenegar;

use Aryala7\Chapaar\Contracts\DriverConnector;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class KavenegarConnector implements DriverConnector
{

    const PATH = "%s://api.kavenegar.com/v1/%s/%s/%s.json/";

    protected array|string $receptor ='';
    protected object $setting;
    protected $client;

    protected string $content = '';
    public function __construct(string $content)
    {
        $this->client = (new Client());
        $this->content = $content;
        $this->setting = (object) config('chapaar.drivers.kavenegar');
    }

    public function generatePath($base='sms'):string
    {
        return sprintf(self::PATH, $this->setting->scheme, $this->setting->api_key, $base, $this->setting->method);

    }


    public function setReceptor(array|string $receptor): static
    {
        if (is_array($receptor)) {
            $this->receptor = implode(',',$receptor);
        }else {
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
    public function send()
    {
        $url = self::generatePath();
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'charset' => 'utf-8'
        ])->send($this->setting->method, $url, [
            'body' => http_build_query($this->prepareData()),
            'http_errors' => false
        ]);
        $result = $response->body();
        if (!$response->successful()) {
            return $result; //todo:handle exception
        }
        return $result;

    }

    public function prepareData():array
    {
        return [
            'receptor' => $this->getReceptor(),
            'message' => $this->content,
            'sender' => $this->setting->line_number,
            'date' => null,
            'type' => null,
            'local' => null,
//            'hide' => ''
        ];
    }

    public function setContent()
    {
        // TODO: Implement setContent() method.
    }

    public function setReceptors()
    {
        // TODO: Implement setReceptors() method.
    }
}
