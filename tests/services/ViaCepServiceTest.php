<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\ViaCepService;

/**
 * Unit tests for the ViaCepService class.
 *
 * This test suite verifies the behavior of the ViaCepService when fetching
 * address data based on a given CEP (postal code). It includes tests for:
 * - Valid CEPs, ensuring the service returns the correct address data.
 * - Invalid CEPs, ensuring the service returns null.
 *
 * Mocks the fetchContent method to simulate API responses.
 */
class ViaCepServiceTest extends TestCase
{
    private $viaCepService;

    protected function setUp(): void
    {
        $this->viaCepService = $this->getMockBuilder(ViaCepService::class)
            ->onlyMethods(['fetchContent'])
            ->getMock();
    }

    public function test_valid_cep_returns_address_data(): void
    {
        $validCep = '01001000';
        $expectedData = [
            'cep' => '01001-000',
            'logradouro' => 'Praça da Sé',
            'bairro' => 'Sé',
            'localidade' => 'São Paulo',
            'uf' => 'SP'
        ];

        $this->viaCepService->expects($this->once())
            ->method('fetchContent')
            ->with('https://viacep.com.br/ws/01001000/json/')
            ->willReturn(json_encode($expectedData));

        $result = $this->viaCepService->fetchCepData($validCep);

        $this->assertEquals($expectedData, $result);
    }

    public function test_invalid_cep_returns_null(): void
    {
        $invalidCep = '00000000';
        $errorResponse = ['erro' => true];

        $this->viaCepService->expects($this->once())
            ->method('fetchContent')
            ->with('https://viacep.com.br/ws/00000000/json/')
            ->willReturn(json_encode($errorResponse));

        $result = $this->viaCepService->fetchCepData($invalidCep);

        $this->assertNull($result);
    }
}

