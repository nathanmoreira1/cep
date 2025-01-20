<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Utils\Router;

header('Content-Type: application/json');

try {
    $router = new Router();

    $routesFile = __DIR__ . '/../src/routes/web.php';

    if (file_exists($routesFile)) {
        include $routesFile;
    } else {
        throw new Exception('Routes file not found.');
    }

    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Internal Server Error',
        'message' => $e->getMessage(),
    ]);
}
