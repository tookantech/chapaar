<?php

return [

    // Set the default driver for the Chapaar package
    'default' => env('CHAPAAR_DRIVER', 'kavenegar'),

    // Define configurations for different drivers
    'drivers' => [
        // Configuration for the 'kavenegar' driver
        'kavenegar' => [
            'url' => 'https://api.kavenegar.com/v1/',
            'method' => 'post',
            'api_key' => '',
            'line_number' => '',
        ],
        // Configuration for the 'smsir' driver
        'smsir' => [
            'url' => 'https://api.sms.ir/v1/',
            'api_key' => '',
            'line_number' => '',
        ],
        // Configuration for the 'ghasedak' driver
        'ghasedak' => [
            'url' => 'http://api.ghasedak.me/v2/',
            'api_key' => '',
            'line_number' => '',
        ],
    ],
];
