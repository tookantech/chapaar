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

    public function outbox($page_size = 100, $page_number = 1): object;

    public function generateResponse(int $status, string $message, string $driver, array $data = null): object;

    public function generateAccountResponse($credit, $expire_date): object;

    public function generateReportResponse($message_id, $receptor, $content, $sent_date, $line_number, $cost): object;
}
