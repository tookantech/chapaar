<?php

namespace TookanTech\Chapaar\Drivers\Farapayamak;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use TookanTech\Chapaar\Contracts\DriverConnector;
use TookanTech\Chapaar\Exceptions\ApiException;
use TookanTech\Chapaar\Exceptions\HttpException;
use TookanTech\Chapaar\Traits\HasResponse;

class FarapayamakConnector implements DriverConnector
{
    use HasResponse;

    protected Client $client;

    protected string $content = '';

    public function __construct()
    {
        self::$setting = (object) config('chapaar.drivers.farapayamak');
        $this->client = new Client([
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'charset' => 'utf-8',
            ],
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::TIMEOUT => config('chapaar.timeout'),
            RequestOptions::CONNECT_TIMEOUT => config('chapaar.connect_timeout'),
        ]);

    }

    /**
     * @param  FarapayamakMessage  $message
     *
     * @throws GuzzleException
     */
    public function send($message): object
    {
        $url = self::endpoint('SendSMS');
        $params = [
            'from' => $message->getFrom(),
            'to' => $message->getTo(),
            'text' => $message->getContent(),
            'isFlash' => $message->isFlash(),
        ];
        $response = $this->performApi($url, $params);

        return $this->generateResponse($response->RetStatus, $response->Value, (array) $response->StrRetStatus);
    }

    /**
     * @param  FarapayamakMessage  $message
     *
     * @throws GuzzleException
     */
    public function verify($message): object
    {
        $url = self::endpoint('BaseServiceNumber');
        $params = [
            'text' => $message->getTokens(),
            'to' => $message->getTo(),
            'bodyId' => $message->getTemplate(),
        ];

        $response = $this->performApi($url, $params);

        return $this->generateResponse($response->result->RetStatus, $response->result->StrRetStatus, (array) $response->Value);

    }

    /**
     * @throws GuzzleException
     */
    public function account(): object
    {
        $url = self::endpoint('GetCredit2');
        $response = $this->performApi($url);

        return $this->generateAccountResponse($response->Value, 0);
    }

    /**
     * @throws GuzzleException
     */
    public function outbox($page_size = 100, $page_number = 1): object
    {
        $url = self::endpoint('GetMessages');
        $params = [
            'location' => 2, // sent messages
            'index' => 0,
            'count' => 100,
        ];
        $response = $this->performApi($url, $params);

        return collect($response->Data)->map(function ($item) {
            return $this->generateReportResponse($item->MsgID, $item->Receiver, $item->Body, $item->SendDate, $item->Sender);
        });
    }

    /**
     * @throws GuzzleException
     */
    public function performApi(string $url, array $params = []): object
    {

        $params = [...$params, ...[
            'username' => $this->setting->username,
            'password' => $this->setting->password,
        ]];
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

        if ($json_response->result->RetStatus !== 1) {
            throw new ApiException($json_response->result->message, $json_response->result->code);
        }
    }
}
