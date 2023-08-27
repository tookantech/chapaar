<?php

namespace TookanTech\Chapaar\Traits;

trait HasResponse
{
    public static object $setting;

    public static function endpoint(...$params): string
    {
        $params = implode('/', $params);

        return self::$setting->url.$params;
    }

    public function generateResponse(int $status, string $message, $data = null): object
    {
        return (object) [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }

    protected function processApiResponse($response): object
    {
        $status_code = $response->getStatusCode();
        $json_response = json_decode($response->getBody()->getContents());
        $this->validateResponseStatus($status_code, $json_response);
        return $json_response;
    }
}
