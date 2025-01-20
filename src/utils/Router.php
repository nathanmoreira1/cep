<?php

namespace App\Utils;

class Router
{
    private $routes = [];

    /**
     * Adiciona uma rota ao roteador.
     *
     * @param string $method O método HTTP (GET, POST, etc.).
     * @param string $path O caminho da rota.
     * @param callable $handler O manipulador da rota.
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
     * Processa a requisição e despacha a rota correspondente.
     *
     * @param string $method O método HTTP da requisição.
     * @param string $uri O URI da requisição.
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
     * Normaliza o caminho da rota, removendo barras desnecessárias.
     *
     * @param string $path O caminho a ser normalizado.
     * @return string O caminho normalizado.
     */
    private function normalizePath(string $path): string
    {
        return '/' . trim($path, '/');
    }
}
