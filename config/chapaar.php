<?php

return [
    'default' => env('CHAPAAR_DRIVER', 'kavenegar'),

    'drivers' => [
        'kavenegar' => [
            'method' => 'post',
            'scheme' => 'http',
            'api_key' => '',
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
