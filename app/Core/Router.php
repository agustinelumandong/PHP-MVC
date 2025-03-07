<?php

namespace Core;

class Router {
    protected array $routes = [];
    protected array $params = [];
    protected string $currentRoute = '';

    public function add(string $route, array $params = []): void {
        $route = preg_replace('/\//', '\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[^/]+)', $route);
        $route = '/^' . $route . '\/?$/i';
        $this->routes[$route] = $params;
    }

    public function match(string $url): bool {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                $this->currentRoute = $route;
                return true;
            }
        }
        return false;
    }

    public function getParams(): array {
        return $this->params;
    }

    public function dispatch(string $url): void {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = "App\\Controllers\\{$controller}Controller";

            if (class_exists($controller)) {
                $controllerObject = new $controller();

                $action = $this->params['action'] ?? 'index';
                $action = $this->convertToCamelCase($action);

                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Method $action in controller $controller not found");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            throw new \Exception('No route matched.', 404);
        }
    }

    protected function convertToStudlyCaps(string $string): string {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    protected function convertToCamelCase(string $string): string {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    protected function removeQueryStringVariables(string $url): string {
        if ($url !== '') {
            $parts = explode('?', $url, 2);
            return $parts[0];
        }
        return $url;
    }
}