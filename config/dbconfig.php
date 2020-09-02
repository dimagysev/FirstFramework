<?php
return [
    'connection' => getenv('DB_CONNECTION'),

    'connections' => [

        /*'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],*/

        'mysql' => [
            'driver'     => 'mysql',
            'host'       => getenv('DB_HOST') ?? '127.0.0.1',
            'port'       => getenv('DB_PORT') ?? '3306',
            'database'   => getenv('DB_DATABASE') ?? 'database',
            'username'   => getenv('DB_USERNAME') ?? 'root',
            'password'   => getenv('DB_PASSWORD') ?? 'secret',
            'charset'    => 'utf8mb4',
            'options'    =>  [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ],
        ],
    ]
];