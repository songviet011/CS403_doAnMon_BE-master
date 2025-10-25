<?php
return [
    'username' => env('SEPAY_USERNAME'),
    'password' => env('SEPAY_PASSWORD'),
    'api_key'  => env('SEPAY_API_KEY'),
    'pattern'  => 'DH',
    'webhook_token' => env('SEPAY_WEBHOOK_TOKEN', null),
];
