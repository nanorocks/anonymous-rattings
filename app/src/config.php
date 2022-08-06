<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . './../');
$dotenv->load();

return [
    'appName' => $_ENV['APP_NAME'],
    'show_errors' => $_ENV['APP_NAME'],
    'db' => [
        'driver' => $_ENV['DB_DRIVE'],
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_DATABASE'],
        'username' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'charset' => $_ENV['DB_CHARSET'],
        'collation' => $_ENV['DB_COLLECTION'],
        'prefix' => $_ENV['DB_PREFIX'],
    ],
    'accessToken' => $_ENV['ACCESS_TOKEN'],
    'logger' => [
        'path' => $_ENV['LOGGER_PATH']
    ]
];
