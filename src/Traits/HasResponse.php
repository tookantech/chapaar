<?php

namespace TookanTech\Chapaar\Traits;

use TookanTech\Chapaar\Exceptions\ApiException;
use TookanTech\Chapaar\Exceptions\HttpException;

trait HasResponse
{
    public static object $setting;

    /**
     * @param ...$params
     * @return string
     */
    public static function endpoint(...$params): string
    {
        $params = implode('/', $params);

        return self::$setting->url.$params;
    }

    /**
     * @return object
     */
    public static function setting():object
    {
        return self::$setting;
    }

    /**
     * @param int $status
     * @param string $message
     * @param $data
     * @return object
     */
    public function generateResponse(int $status, string $message, $data = null): object
    {
        return (object) [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * @param $response
     * @return object
     * @throws HttpException | ApiException
     */
    protected function processApiResponse($response): object
    {
        $status_code = $response->getStatusCode();
        $json_response = json_decode($response->getBody()->getContents());
        $this->validateResponseStatus($status_code, $json_response);

        return $json_response;
    }
}
