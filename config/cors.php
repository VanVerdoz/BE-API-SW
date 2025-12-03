<?php

return [
    'paths' => ['*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://127.0.0.1:8001',
        'http://localhost:8001',
        'http://127.0.0.1:3000',
        'http://localhost:3000',
        'http://127.0.0.1:8000',
        'http://localhost:8000',
    ],
    'allowed_headers' => ['*'],
    'supports_credentials' => true,
];
