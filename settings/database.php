<?php

return [
    /**
     * Подключение по умолчанию.
     *
     * Используется для подключения к базе данных по умолчанию.
     */
    'default' => env('DB_CONNECTION', 'sqlite'),

    /**
     * Соединения.
     */
    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'prefix' => '',
            'url' => env('DATABASE_URL'),
            'database' => project_path('database/'.env('DB_DATABASE', 'alice').'.sqlite'),
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'prefix' => env('DB_PREFIX'),
            'database' => env('DB_DATABASE', 'alice'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'prefix_indexes' => true,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'strict' => false,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'prefix' => env('DB_PREFIX'),
            'database' => env('DB_DATABASE', 'alice'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'prefix_indexes' => true,
            'charset' => 'utf8',
        ],

    ],
];
