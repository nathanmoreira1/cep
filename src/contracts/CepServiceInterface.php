<?php

namespace App\Contracts;

interface CepServiceInterface
{
    /**
     * Busca informações de um CEP.
     *
     * @param string $cep O CEP a ser buscado.
     * @return array|null Os dados do CEP ou null se não encontrados.
     */
    public function fetchCepData(string $cep): ?array;
}
