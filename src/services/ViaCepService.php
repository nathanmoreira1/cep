<?php

namespace App\Services;

use App\Contracts\CepServiceInterface;
use Exception;

class ViaCepService implements CepServiceInterface
{
    private const BASE_URL = 'https://viacep.com.br/ws/';

    /**
     * Retrieves the content of the specified URL.
     *
     * @param string $url The URL from which to fetch the content.
     * @return string|false The content of the URL or false on failure.
     */
    public function fetchContent(string $url)
    {
        return file_get_contents($url);
    }

    /**
     * Fetches address data for a given CEP (postal code) from the ViaCep service.
     *
     * @param string $cep The CEP to be queried.
     * @return array|null An associative array containing the address data, or null if an error occurs or the CEP is invalid.
     */
    public function fetchCepData(string $cep): ?array
    {
        $url = self::BASE_URL . $cep . '/json/';
        try {
            $response = $this->fetchContent($url);
            $data = json_decode($response, true, 512, JSON_UNESCAPED_UNICODE);

            if (isset($data['erro'])) {
                return null;
            }

            return $data;
        } catch (Exception $e) {
            error_log('Erro ao consultar o CEP: ' . $e->getMessage());
            return null;
        }
    }
}

