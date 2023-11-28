<?php

return [

    /*
     * Set the default driver for the Chapaar package
     */
    'default' => env('CHAPAAR_DRIVER'),

    /*
     * This is the name of the table that will be created by the migration and
     * used by the SmsMessage model shipped with this package.
     */
    'table_name' => 'sms_messages',

    /*
     * If set to false, no messages will be saved to the database.
     */
    'status' => false,

    /*
     * Define configurations for different drivers
     */
    'drivers' => [
        /* Configuration for the 'kavenegar' driver */
        'kavenegar' => [
            'title' => 'chapaar::driver.kavenegar',
            'url' => 'https://api.kavenegar.com/v1/',
            'method' => 'post',
            'api_key' => '',
            'line_number' => '',
        ],
        /* Configuration for the 'smsir' driver */
        'smsir' => [
            'title' => 'chapaar::driver.smsir',
            'url' => 'https://api.sms.ir/v1/',
            'api_key' => '',
            'line_number' => '',
        ],
        /* Configuration for the 'ghasedak' driver */
        'ghasedak' => [
            'title' => 'chapaar::driver.ghasedak',
            'url' => 'http://api.ghasedak.me/v2/',
            'api_key' => '',
            'line_number' => '',
        ],
        /* Configuration for the 'ghasedak' driver */
        'farapayamak' => [
            'title' => 'chapaar::driver.farapayamak',
            'url' => 'https://rest.payamak-panel.com/api/SendSMS/%s',
            'username' => '',
            'password' => '',
        ],
    ],
];
