<?php

namespace App\Contracts;

interface CepServiceInterface
{
    /**
     * Fetches information for a ZIP code.
     *
     * @param string $cep The ZIP code to be searched.
     * @return array|null The ZIP code data or null if not found.
     */
    public function fetchCepData(string $cep): ?array;
}