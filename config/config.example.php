<?php
// config/config.php
// Application configuration

return [
    'database' => [
        'host' => 'localhost',
        'dbname' => 'job_application',
        'username' => 'appuser',
        'password' => 'apppass',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ],
    'app' => [
        'name' => 'Job Application System',
        'debug' => true,
        'timezone' => 'UTC',
    ],
];
