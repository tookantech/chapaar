<?php

namespace TookanTech\Chapaar\Traits;

trait HasResponse
{
    protected static object $setting;
    /**
     * @param ...$params
     * @return string
     */
    public static function endpoint(...$params): string
    {
        $params = implode('/',$params);
        return self::$setting->url . $params;
    }
    public function generateResponse(int $status, string $message, $data = null): object
    {
        return (object) [
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ];
    }
}
