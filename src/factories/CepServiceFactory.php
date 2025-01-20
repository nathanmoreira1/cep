<?php

namespace App\Factories;

use App\Contracts\CepServiceInterface;

class CepServiceFactory
{
    public static function create(): CepServiceInterface
    {
        // Resolver a implementação do serviço de CEP (pode ser configurado)
        $config = require __DIR__ . '/../../config/services.php';
        $cepServiceClass = $config['cep_service'];

        // Criar a instância do serviço de CEP
        return new $cepServiceClass(); 
    }
}
