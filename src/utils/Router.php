<?php

namespace App\Utils;

class Router
{
    private $routes = [];

    /**
     * Adds a route to the router.
     *
     * @param string $method The HTTP method (GET, POST, etc.).
     * @param string $path The path of the route.
     * @param callable $handler The route handler.
     */
    public function add(string $method, string $path, callable $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $this->normalizePath($path),
            'handler' => $handler,
        ];
    }

    /**
     * Processes the request and dispatches the corresponding route.
     *
     * @param string $method The HTTP method of the request.
     * @param string $uri The URI of the request.
     */
    public function dispatch(string $method, string $uri)
    {
        $uri = $this->normalizePath(parse_url($uri, PHP_URL_PATH));

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                call_user_func($route['handler']);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
    }

    /**
     * Normalizes the route path by removing unnecessary slashes.
     *
     * @param string $path The path to be normalized.
     * @return string The normalized path.
     */
    private function normalizePath(string $path): string
    {
        return '/' . trim($path, '/');
    }
}
