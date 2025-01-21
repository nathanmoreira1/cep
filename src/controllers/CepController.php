<?php

namespace App\Controllers;

use App\Contracts\CepServiceInterface;
use App\Utils\Response;

/**
 * CepController handles requests related to CEP data retrieval.
 * 
 * This controller uses the CepServiceInterface to fetch data for a given CEP.
 * It validates the CEP format and returns appropriate HTTP responses based on
 * the success or failure of the data retrieval process.
 */
class CepController
{
    private CepServiceInterface $cepService;

    public function __construct(CepServiceInterface $cepService)
    {
        $this->cepService = $cepService;
    }

    /**
     * Retrieves CEP data based on the 'cep' parameter from the GET request.
     * 
     * Validates the CEP format and returns a 400 response if invalid or missing.
     * If the CEP is valid, attempts to fetch data using the CepServiceInterface.
     * Returns a 200 response with the data if found, or a 404 response if not.
     */
    public function getCepData()
    {
        $cep = $_GET['cep'] ?? null;

        if (!$cep || !preg_match('/^\d{8}$/', $cep)) {
            echo Response::createResponse(400, [
                'status' => 400,
                'data' => ['error' => 'Invalid or missing CEP']
            ]);
            return;
        }

        $data = $this->cepService->fetchCepData($cep);

        if ($data) {
            echo Response::createResponse(200, [
                'status' => 200,
                'data' => $data
            ]);
        } else {
            echo Response::createResponse(404, [
                'status' => 404,
                'data' => ['error' => 'CEP not found']
            ]);
        }
    }
}
