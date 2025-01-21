<?php

namespace App\Utils;

class ServiceContainer
{
    private array $services = [];

    /**
     * Registers a service with a given name and its resolver.
     *
     * @param string $name The name of the service to register.
     * @param callable $resolver The resolver function that returns the service instance.
     * @return void
     */
    public function register(string $name, callable $resolver): void
    {
        $this->services[$name] = $resolver;
    }

    /**
     * Resolves and returns the instance of a registered service by its name.
     *
     * @param string $name The name of the service to resolve.
     * @return mixed The resolved service instance.
     * @throws \Exception If the service is not found in the container.
     */
    public function resolve(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new \Exception("Service '{$name}' not found in container.");
        }

        return call_user_func($this->services[$name]);
    }
}
