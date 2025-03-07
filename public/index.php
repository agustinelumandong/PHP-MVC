<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Load configuration
$config = require_once dirname(__DIR__) . '/config/config.php';

// Error handling
ini_set('display_errors', $config['app']['debug'] ? '1' : '0');
ini_set('display_startup_errors', $config['app']['debug'] ? '1' : '0');
error_reporting($config['app']['debug'] ? E_ALL : 0);

// Set timezone
date_default_timezone_set($config['app']['timezone']);

// Start session
session_start();

// Create Router instance
$router = new Core\Router();

// Load routes
$routes = require_once dirname(__DIR__) . '/config/routes.php';
foreach ($routes as $route => $params) {
    $router->add($route, $params);
}

// Dispatch the request
try {
    $router->dispatch($_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    if ($config['app']['debug']) {
        echo '<h1>Error</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo '<h1>500 Internal Server Error</h1>';
        echo '<p>Something went wrong. Please try again later.</p>';
    }
}