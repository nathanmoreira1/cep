<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Utils\ServiceContainer;
use App\Contracts\CepServiceInterface;

class BootstrapTest extends TestCase
{
    private $container;

    protected function setUp(): void
    {
        // Includes the bootstrap file and initializes the container
        $this->container = require __DIR__ . '/../../bootstrap.php';
    }

    public function test_resolves_registered_dependency(): void
    {
        $service = $this->container->resolve(CepServiceInterface::class);

        $this->assertInstanceOf(CepServiceInterface::class, $service);
    }

    public function test_throws_exception_for_unregistered_dependency(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Service 'UnregisteredService' not found in container.");

        $this->container->resolve('UnregisteredService');
    }

    public function test_controller_factory_is_registered(): void
    {
        $controllerFactory = $this->container->resolve('controller_factory');

        $this->assertInstanceOf(\App\Factories\ControllerFactory::class, $controllerFactory);
    }
}