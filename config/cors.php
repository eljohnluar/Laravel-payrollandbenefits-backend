<?php

$default = 'https://payrollandbenefits-frontend.vercel.app,http://localhost:5173';
$origins = array_values(array_filter(array_map(
    static fn ($o) => rtrim(trim($o), '/'),
    explode(',', (string) env('FRONTEND_ORIGIN', $default))
), static fn ($o) => $o !== ''));

return [
    'paths' => ['api/*', 'up'],

    'allowed_methods' => ['GET', 'POST', 'PATCH', 'PUT', 'DELETE', 'OPTIONS'],

    'allowed_origins' => $origins,

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With', 'X-Api-Key', 'Accept'],

    'exposed_headers' => [],

    'max_age' => 600,

    'supports_credentials' => false,
];
