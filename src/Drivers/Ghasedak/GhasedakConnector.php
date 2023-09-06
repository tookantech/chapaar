<?php

namespace TookanTech\Chapaar\Drivers\Ghasedak;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use TookanTech\Chapaar\Contracts\DriverConnector;
use TookanTech\Chapaar\Exceptions\ApiException;
use TookanTech\Chapaar\Exceptions\HttpException;
use TookanTech\Chapaar\Traits\HasResponse;

class GhasedakConnector implements DriverConnector
{
    use HasResponse;

    protected Client $client;

    protected string $content = '';

    public function __construct()
    {
        self::$setting = (object) config('chapaar.drivers.ghasedak');
        $this->client = new Client([
            'headers' => [
                'apikey' => self::$setting->api_key,
                'cache-control' => 'no-cache',
                'content-type' => 'application/x-www-form-urlencoded',
            ],
        ]);

    }

    /**
     * @param  GhasedakMessage  $message
     *
     * @throws GuzzleException
     */
    public function send($message): object
    {
        $url = self::endpoint('sms', 'send', 'simple');
        $params = [
            'linenumber' => $message->getFrom() ?: self::$setting->line_number,
            'message' => $message->getContent(),
            'receptor' => $message->getTo(),
            'senddate' => $message->getDate(),
            'checkid' => $message->getCheckId() ?? null,
        ];
        $response = $this->performApi($url, $params);

        return $this->generateResponse($response->result->code, $response->result->message, (array) $response->items);
    }

    /**
     * @param  GhasedakMessage  $message
     *
     * @throws GuzzleException
     */
    public function verify($message): object
    {
        $url = self::endpoint('verification', 'send', 'simple');
        $params = [
            'receptor' => $message->getTo(),
            'type' => $message->getType(),
            'template' => $message->getTemplate(),
        ];

        $params = [...$params, ...$message->getTokens()];
        $response = $this->performApi($url, $params);

        return $this->generateResponse($response->result->code, $response->result->message, (array) $response->items);

    }

    /**
     * @throws GuzzleException
     */
    public function account(): object
    {
        $url = self::endpoint('account', 'info');
        $response = $this->performApi($url);

        $items = $response->items;

        return $this->generateAccountResponse($items->balance, $items->expire);
    }

    /**
     * @throws GuzzleException
     */
    public function outbox($page_size = 100, $page_number = 1): object
    {
        $url = self::endpoint('sms', 'status');
        $response = $this->performApi($url);

        return collect($response->items)->map(function ($item) {
            return $this->generateReportResponse($item->messageid, $item->receptor, $item->message, $item->senddate, $item->sender, $item->price);
        });
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

        return $json_response;

    }

    protected function validateResponseStatus($status_code, $json_response): void
    {
        if ($json_response === null) {
            throw new HttpException('Response is not valid JSON', $status_code);
        }

        if ($json_response->result->code !== Response::HTTP_OK) {
            throw new ApiException($json_response->result->message, $json_response->result->code);
        }
    }
}
