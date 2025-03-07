<?php

namespace App\Middleware;

class AuthMiddleware {
    public function handle(): bool {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page
            header('Location: /login');
            exit;
        }

        return true;
    }

    public function guest(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is NOT logged in
        if (isset($_SESSION['user_id'])) {
            // Redirect to home page
            header('Location: /');
            exit;
        }

        return true;
    }
}