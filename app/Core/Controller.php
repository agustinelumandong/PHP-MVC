<?php

namespace Core;

class Controller {
    protected function render(string $view, array $data = []): void {
        extract($data);
        
        $viewFile = dirname(__DIR__) . "/Views/{$view}.php";
        if (file_exists($viewFile)) {
            require_once dirname(__DIR__) . "/Views/layouts/header.php";
            require_once $viewFile;
            require_once dirname(__DIR__) . "/Views/layouts/footer.php";
        } else {
            throw new \Exception("View file {$view}.php not found");
        }
    }

    protected function getPostData(): array {
        return $_POST;
    }

    protected function redirect(string $url): void {
        header("Location: {$url}");
        exit;
    }

    protected function json(array $data, int $statusCode = 200): void {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}