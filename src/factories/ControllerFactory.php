<?php

namespace App\Factories;

use App\Utils\ServiceContainer;

class ControllerFactory
{
    private $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    // Método genérico para criar qualquer controlador
    public function create(string $controllerClass)
    {
        // Verifica se o controlador tem dependências e resolve elas automaticamente
        $reflection = new \ReflectionClass($controllerClass);
        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            // Caso o controlador não tenha construtor, apenas instancie
            return new $controllerClass();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            if ($type && $type->getName()) {
                // Verifica se o tipo é uma classe e resolve a dependência no container
                $dependency = $this->container->resolve($type->getName());
                $dependencies[] = $dependency;
            }
        }

        // Cria o controlador com as dependências resolvidas
        return $reflection->newInstanceArgs($dependencies);
    }
}
