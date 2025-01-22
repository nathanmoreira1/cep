<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Utils\Router;

class RouterTest extends TestCase
{
    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testAddRoute(): void
    {
        $this->router->add('GET', '/test', function () {
            echo 'Test Route';
        });

        // Testing if the route was registered correctly
        $reflection = new \ReflectionClass($this->router);
        $routesProperty = $reflection->getProperty('routes');
        $routesProperty->setAccessible(true);
        $routes = $routesProperty->getValue($this->router);

        $this->assertCount(1, $routes);
        $this->assertEquals('/test', $routes[0]['path']);
    }

    public function testDispatchRoute(): void
    {
        $this->router->add('GET', '/hello', function () {
            echo 'Hello World';
        });

        ob_start();
        $this->router->dispatch('GET', '/hello');
        $output = ob_get_clean();

        $this->assertEquals('Hello World', $output);
    }

    public function testMiddlewareExecution(): void
    {
        $this->router->addMiddleware(function ($method, $uri, $params) {
            echo 'Middleware executed';
        });

        $this->router->add('GET', '/test-middleware', function () {
            echo 'Route executed';
        });

        ob_start();
        $this->router->dispatch('GET', '/test-middleware');
        $output = ob_get_clean();

        $this->assertStringContainsString('Middleware executed', $output);
        $this->assertStringContainsString('Route executed', $output);
    }

    public function testNotFoundRoute(): void
    {
        ob_start();
        $this->router->dispatch('GET', '/non-existing-route');
        $output = ob_get_clean();

        $this->assertEquals('{"error":"Endpoint not found"}', $output);
    }
}