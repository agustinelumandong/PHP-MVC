<?php

return [
    'app' => [
        'name' => getenv('APP_NAME') ?? 'MyApp',
        'env' => getenv('APP_ENV') ?? 'development',
        'debug' => getenv('APP_DEBUG') ?? true,
        'url' => getenv('APP_URL') ?? 'http://localhost',
        'timezone' => 'UTC',
        'locale' => 'en'
    ],
    
    'session' => [
        'lifetime' => 120,
        'expire_on_close' => false,
        'secure' => false,
        'http_only' => true,
        'same_site' => 'lax'
    ],
    
    'mail' => [
        'driver' => getenv('MAIL_DRIVER') ?? 'smtp',
        'host' => getenv('MAIL_HOST') ?? 'smtp.mailtrap.io',
        'port' => getenv('MAIL_PORT') ?? 2525,
        'username' => getenv('MAIL_USERNAME') ?? '',
        'password' => getenv('MAIL_PASSWORD') ?? '',
        'encryption' => getenv('MAIL_ENCRYPTION') ?? 'tls'
    ]
];