<?php

namespace App\Services;

use App\Contracts\CepServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ViaCepService implements CepServiceInterface
{
    private const BASE_URL = 'https://viacep.com.br/ws/';
    private Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Fetches address data for a given CEP (postal code) from the ViaCep service.
     *
     * @param string $cep The CEP to be queried.
     * @return array|null An associative array containing the address data, or null if an error occurs or the CEP is invalid.
     */
    public function fetchCepData(string $cep): ?array
    {
        try {
            $response = $this->httpClient->get(self::BASE_URL . $cep . '/json/');
            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_UNESCAPED_UNICODE);

            if (isset($data['erro'])) {
                return null;
            }

            return $data;
        } catch (RequestException $e) {
            error_log('Erro ao consultar o CEP: ' . $e->getMessage());
            return null;
        }
    }
}
