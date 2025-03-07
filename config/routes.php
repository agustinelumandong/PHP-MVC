<?php

return [
    // Home routes
    '/' => ['controller' => 'home', 'action' => 'index'],
    '/about' => ['controller' => 'home', 'action' => 'about'],
    '/contact' => ['controller' => 'home', 'action' => 'contact'],

    // User routes
    '/login' => ['controller' => 'user', 'action' => 'login'],
    '/register' => ['controller' => 'user', 'action' => 'register'],
    '/logout' => ['controller' => 'user', 'action' => 'logout'],
    '/profile' => ['controller' => 'user', 'action' => 'profile'],

    // Dynamic routes example
    '/users/{id}' => ['controller' => 'user', 'action' => 'show'],
    '/posts/{id}' => ['controller' => 'post', 'action' => 'show']
];