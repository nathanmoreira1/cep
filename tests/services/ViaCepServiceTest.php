<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\ViaCepService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * Unit tests for the ViaCepService class.
 *
 * This test suite verifies the behavior of the ViaCepService when fetching
 * address data based on a given CEP (postal code). It includes tests for:
 * - Valid CEPs, ensuring the service returns the correct address data.
 * - Invalid CEPs, ensuring the service returns null.
 *
 * Mocks the GuzzleHttp\Client to simulate API responses.
 */
class ViaCepServiceTest extends TestCase
{
    private $httpClientMock;
    private $viaCepService;

    protected function setUp(): void
    {
        // Mock the GuzzleHttp\Client
        $this->httpClientMock = $this->createMock(Client::class);

        // Inject the mocked HTTP client into the ViaCepService
        $this->viaCepService = new ViaCepService($this->httpClientMock);
    }

    public function test_valid_cep_returns_address_data(): void
    {
        $validCep = '01001000';
        $expectedData = [
            'cep' => '01001-000',
            'logradouro' => 'Praça da Sé',
            'bairro' => 'Sé',
            'localidade' => 'São Paulo',
            'uf' => 'SP',
        ];

        // Simulate a valid response from the API
        $this->httpClientMock->expects($this->once())
            ->method('get')
            ->with('https://viacep.com.br/ws/01001000/json/')
            ->willReturn(new Response(200, [], json_encode($expectedData)));

        $result = $this->viaCepService->fetchCepData($validCep);

        $this->assertEquals($expectedData, $result);
    }

    public function test_invalid_cep_returns_null(): void
    {
        $invalidCep = '00000000';
        $errorResponse = ['erro' => true];

        // Simulate a response indicating an invalid CEP
        $this->httpClientMock->expects($this->once())
            ->method('get')
            ->with('https://viacep.com.br/ws/00000000/json/')
            ->willReturn(new Response(200, [], json_encode($errorResponse)));

        $result = $this->viaCepService->fetchCepData($invalidCep);

        $this->assertNull($result);
    }
}
