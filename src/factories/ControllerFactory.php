<?php

namespace App\Factories;

use App\Utils\ServiceContainer;

/**
 * ControllerFactory is responsible for creating instances of controller classes.
 *
 * It utilizes the ServiceContainer to resolve dependencies required by the
 * controller's constructor through reflection. This allows for automatic
 * dependency injection, ensuring that all necessary services are provided
 * to the controller upon instantiation.
 */
class ControllerFactory
{
    private $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Creates an instance of the specified controller class.
     *
     * Uses reflection to inspect the constructor of the given controller class
     * and resolves its dependencies using the service container.
     *
     * @param string $controllerClass The fully qualified name of the controller class to instantiate.
     * @return object An instance of the specified controller class.
     */
    public function create(string $controllerClass)
    {
        $reflection = new \ReflectionClass($controllerClass);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $controllerClass();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            if ($type && $type->getName()) {
                $dependency = $this->container->resolve($type->getName());
                $dependencies[] = $dependency;
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}

