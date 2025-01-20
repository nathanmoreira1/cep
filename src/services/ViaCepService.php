<?php

namespace App\Services;

use App\Contracts\CepServiceInterface;
use Exception;

class ViaCepService implements CepServiceInterface
{
    private const BASE_URL = 'https://viacep.com.br/ws/';

    public function fetchCepData(string $cep): ?array
    {
        $url = self::BASE_URL . $cep . '/json/';
        try {
            $response = file_get_contents($url);
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
