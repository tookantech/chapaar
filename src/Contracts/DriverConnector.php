<?php

namespace TookanTech\Chapaar\Contracts;

/**
 * @property static $setting
 */
interface DriverConnector
{
    public function account(): object;

    public static function endpoint(...$params): string;
    public static function setting(): object;

    public function performApi(string $url, array $params = []);

    public function send($message);

    public function verify($message);

    public function generateResponse(int $status, string $message, array $data = null): object;

    public function generateAccountResponse(object $response): object;
}
