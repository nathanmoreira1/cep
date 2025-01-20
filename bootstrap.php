<?php

use App\Utils\ServiceContainer;
use App\Factories\CepServiceFactory;
use App\Factories\ControllerFactory;
use App\Contracts\CepServiceInterface;

// Criar o container
$container = new ServiceContainer();

// Registrar o serviço de CEP
$container->register(CepServiceInterface::class, function () {
    return CepServiceFactory::create();  // A fábrica lida com a criação do serviço
});

// Registrar a ControllerFactory
$container->register('controller_factory', function () use ($container) {
    return new ControllerFactory($container);
});

return $container;
