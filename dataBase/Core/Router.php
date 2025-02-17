<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $uri, callable $action): void
    {
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes[$method] ?? [] as $route => $action) {
            $routePattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);

            if (preg_match("@^{$routePattern}$@", $uri, $matches)) {
                array_shift($matches);

                if (is_callable($action)) {
                    call_user_func_array($action, $matches);
                } else {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Invalid route handler']);
                }

                return;
            }
        }

        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Route not found']);
    }
}