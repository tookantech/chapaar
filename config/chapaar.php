<?php

return [

    // Set the default driver for the Chapaar package
    'default' => env('CHAPAAR_DRIVER', 'kavenegar'),

    // Define configurations for different drivers
    'drivers' => [
        // Configuration for the 'kavenegar' driver
        'kavenegar' => [
            'url' => '%s://api.kavenegar.com/v1/%s/%s/%s.json/',
            'method' => 'post',
            'scheme' => 'http',
            'api_key' => '',
            'line_number' => '',
        ],
        // Configuration for the 'smsir' driver
        'smsir' => [
            'url' => 'https://api.sms.ir/%s/%s/%s',
            'version' => 'v1',
            'api_key' => '',
            'line_number' => '',
        ],
        // Configuration for the 'ghasedak' driver
        'ghasedak' => [
            'url' => 'http://api.ghasedak.me/%s/%s/%s/%s',
            'version' => 'v1',
            'api_key' => '',
            'line_number' => '',
        ],
    ],
];
