<?php


return [
    'default' => $_ENV['DB_SOURCE'] ?? 'json',
    'connections' => [
        'mysql' => [
            'host' => $_ENV['DB_HOST'] ?? 'localhost',
            'dbname' => $_ENV['DB_NAME'] ?? 'test_db',
            'user' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? '123',
        ],
        'json' => [
            'file_path' => __DIR__ . '/../storage/user.json',
        ],
    ],
];