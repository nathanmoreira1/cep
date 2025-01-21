<?php

use App\Utils\ServiceContainer;
use App\Factories\CepServiceFactory;
use App\Factories\ControllerFactory;
use App\Contracts\CepServiceInterface;

$container = new ServiceContainer();

$container->register(CepServiceInterface::class, function () {
    return CepServiceFactory::create();
});

$container->register('controller_factory', function () use ($container) {
    return new ControllerFactory($container);
});

return $container;
