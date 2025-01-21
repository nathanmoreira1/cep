<?php

namespace App\Factories;

use App\Contracts\CepServiceInterface;
use GuzzleHttp\Client;

/**
 * Creates an instance of the CEP service.
 *
 * Loads the service configuration from the services.php file and
 * instantiates the CEP service class specified in the configuration.
 *
 * @return CepServiceInterface An instance of the configured CEP service.
 */
class CepServiceFactory
{   
    /**
     * Creates an instance of the CEP service.
     *
     * Loads the service configuration from the services.php file and
     * instantiates the CEP service class specified in the configuration.
     *
     * @return CepServiceInterface An instance of the configured CEP service.
     */
    public static function create(): CepServiceInterface
    {
        $config = require __DIR__ . '/../../config/services.php';
        $cepServiceClass = $config['cep_service'];
        $httpClient = new Client([
            'timeout'  => 5.0,
        ]); 
        return new $cepServiceClass($httpClient); 
    }
}

