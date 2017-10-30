<?php

$config = new Phalcon\Config([
    'selfhost' => [
        'address' => 'localhost:8080',
    ],
    'application' => [
        'name' => 'Hungarofit',
    ],
    'database' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'dbname' => 'hungarofit',
        'username' => getenv('HFIT_DB_USER'),
        'password' => getenv('HFIT_DB_PASS'),
        'charset' => 'utf8',
    ],
    'google' => [
        'auth_config' => __DIR__ . '/config/google.json',
    ],
]);

return $config;