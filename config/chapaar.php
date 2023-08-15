<?php

return [
    'default' => env('CHAPAAR_DRIVER', 'kavenegar'),

    'drivers' => [
        'kavenegar' => [
            'url' => '%s://api.kavenegar.com/v1/%s/%s/%s.json/',
            'method' => 'post',
            'scheme' => 'http',
            'api_key' => '7959394764735A684E4364617358613568585973716E5368326C7A7675537463627773506738464E716F513D',
            'line_number' => '1000689696',
        ],
        'smsir' => [
            'url' => 'https://api.sms.ir/%s/%s/%s',
            'version' => 'v1',
            'api_key' => '',
            'line_number' => '',
        ],
        'ghasedak' => [
            'url' => 'http://api.ghasedak.me/%s/%s/%s/%s',
            'version' => 'v1',
            'api_key' => '',
            'line_number' => '',
        ],
    ],
];
