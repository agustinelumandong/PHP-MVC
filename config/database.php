<?php

return [
    'host' => getenv('DB_HOST') ?? 'localhost',
    'database' => getenv('DB_NAME') ?? 'myapp',
    'username' => getenv('DB_USER') ?? 'root',
    'password' => getenv('DB_PASS') ?? '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => ''
];