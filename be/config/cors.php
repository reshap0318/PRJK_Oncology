<?php

return [
    'paths' => ['*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        env('APP_FRONTEND_URL', 'http://localhost:5173'),
        'http://localhost:5173',
        'http://localhost:4173',
        'http://192.168.31.19:1012'
    ],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
