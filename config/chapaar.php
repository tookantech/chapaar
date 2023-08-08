<?php

return [
    'default' => env('CHAPAAR_DRIVER', 'kavenegar'),

    'drivers' => [
        'kavenegar' => [
            'method' => 'post',
            'scheme' => 'http',
            'api_key' => '7959394764735A684E4364617358613568585973716E5368326C7A7675537463627773506738464E716F513D',
            'line_number' => '1000689696',
            'template' => '',
        ],
        'smsir' => [
            'version' => 'v1',
            'api_key' => '',
            'line_number' => '1000689696',
            'template_id' => '',
        ],
    ],
];
