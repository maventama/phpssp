<?php
// app/config.php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

return [
    'db' => [
        'host' => $_ENV['DB_HOST'],
        'name' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS'],
        'port' => $_ENV['DB_PORT'],
    ],
    'rate_limiter' => [
        'max_requests' => $_ENV['RATE_LIMITER_MAX_REQUESTS'],
        'time_window' => $_ENV['RATE_LIMITER_TIME_WINDOW'],
    ]
];
