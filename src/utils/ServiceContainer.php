<?php

namespace App\Utils;

class ServiceContainer
{
    private array $services = [];

    // Registra o serviço no container
    public function register(string $name, callable $resolver): void
    {
        $this->services[$name] = $resolver;
    }

    // Resolve o serviço e retorna a instância
    public function resolve(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new \Exception("Service '{$name}' not found in container.");
        }

        return call_user_func($this->services[$name]);
    }
}
