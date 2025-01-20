<?php

$container = require __DIR__ . '/../../bootstrap.php';

$controllerFactory = $container->resolve('controller_factory');

$cepController = $controllerFactory->create(App\Controllers\CepController::class);

$router->add('GET', '/cep', [$cepController, 'getCepData']);
