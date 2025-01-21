<?php

namespace App\Utils;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    /**
     * Adds a route to the router.
     *
     * @param string $method The HTTP method (GET, POST, etc.).
     * @param string $path The path of the route, supporting dynamic parameters.
     * @param callable $handler The route handler.
     */
    public function add(string $method, string $path, callable $handler)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $this->normalizePath($path),
            'handler' => $handler,
        ];
    }

    /**
     * Adds a middleware to be executed before route handlers.
     *
     * @param callable $middleware The middleware to add.
     */
    public function addMiddleware(callable $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * Dispatches the request and executes the matching route.
     *
     * @param string $method The HTTP method of the request.
     * @param string $uri The URI of the request.
     */
    public function dispatch(string $method, string $uri)
    {
        $uri = $this->normalizePath(parse_url($uri, PHP_URL_PATH));
        $params = [];

        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $this->match($route['path'], $uri, $params)) {
                // Execute middlewares
                foreach ($this->middlewares as $middleware) {
                    $middleware($method, $uri, $params);
                }

                // Call the route handler with parameters
                call_user_func_array($route['handler'], $params);
                return;
            }
        }

        // Route not found
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
    }

    /**
     * Matches a URI to a route path with dynamic parameters.
     *
     * @param string $routePath The route path to match.
     * @param string $uri The URI to match.
     * @param array $params The matched parameters (by reference).
     * @return bool True if the route matches, false otherwise.
     */
    private function match(string $routePath, string $uri, array &$params = []): bool
    {
        $routeRegex = preg_replace('/\{([\w]+)\}/', '(?P<$1>[\w-]+)', $routePath);
        $routeRegex = '#^' . $routeRegex . '$#';

        if (preg_match($routeRegex, $uri, $matches)) {
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }

        return false;
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
