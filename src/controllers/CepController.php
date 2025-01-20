<?php

namespace App\Controllers;

use App\Contracts\CepServiceInterface;
use App\Utils\Response;

class CepController
{
    private CepServiceInterface $cepService;

    public function __construct(CepServiceInterface $cepService)
    {
        $this->cepService = $cepService;
    }

    public function getCepData()
    {
        $cep = $_GET['cep'] ?? null;

        if (!$cep || !preg_match('/^\d{8}$/', $cep)) {
            Response::send(400, ['error' => 'Invalid or missing CEP']);
            return;
        }

        $data = $this->cepService->fetchCepData($cep);

        if ($data) {
            Response::send(200, $data);
        } else {
            Response::send(404, ['error' => 'CEP not found']);
        }
    }
}
