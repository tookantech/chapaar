<?php

namespace TookanTech\Chapaar\Traits;

use TookanTech\Chapaar\Exceptions\ApiException;
use TookanTech\Chapaar\Exceptions\HttpException;

trait HasResponse
{
    public static object $setting;

    public static function endpoint(...$params): string
    {
        $params = implode('/', $params);

        return self::$setting->url.$params;
    }

    public static function setting(): object
    {
        return self::$setting;
    }

    public function generateResponse(int $status, string $message, $data = null): object
    {
        return (object) [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * @throws HttpException | ApiException
     */
    protected function processApiResponse($response): object
    {
        $status_code = $response->getStatusCode();
        $json_response = json_decode($response->getBody()->getContents());
        $this->validateResponseStatus($status_code, $json_response);

        return $json_response;
    }

    public function generateAccountResponse($credit,$expire_date): object
    {
        return (object) [
            'credit' => $credit,
            'expire_date' => $expire_date,
        ];
    }

    public function generateReportResponse($message_id,$receptor,$content,$sent_date,$line_number,$cost): object
    {

        return (object)[
            'message_id' => $message_id,
            'receptor' => $receptor,
            'content' => $content,
            'sent_date' => $sent_date,
            'line_number' => $line_number,
            'cost' => $cost,

        ];
    }
}
