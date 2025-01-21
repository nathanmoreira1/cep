<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\CepController;
use App\Contracts\CepServiceInterface;

/**
 * Unit tests for the CepController class.
 *
 * This test suite verifies the behavior of the CepController, ensuring
 * that it correctly handles valid and missing CEP inputs, and that the
 * CepService dependency is properly injected via the constructor.
 *
 * Tests include:
 * - Valid CEP input returns expected address data.
 * - Missing CEP input returns an error response.
 * - Constructor correctly injects the CepService dependency.
 */
class CepControllerTest extends TestCase
{
    private $cepServiceMock;
    private $cepController;

    /**
     * Sets up the test environment for CepControllerTest.
     *
     * Initializes a mock of the CepServiceInterface and injects it into
     * a new instance of CepController, preparing the test case for execution.
     */
    protected function setUp(): void
    {
        $this->cepServiceMock = $this->createMock(CepServiceInterface::class);
        $this->cepController = new CepController($this->cepServiceMock);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_valid_cep_returns_address_data(): void
    {
        $this->cepServiceMock->expects($this->once())
            ->method('fetchCepData')
            ->with('12345678')
            ->willReturn(['address' => 'Test Street']);

        $_GET['cep'] = '12345678';

        $this->expectOutputString(json_encode([
            'status' => 200,
            'data' => ['address' => 'Test Street']
        ]));

        $this->cepController->getCepData();
    }

    public function test_missing_cep_returns_error(): void
    {
        $this->cepServiceMock->expects($this->never())
            ->method('fetchCepData');

        $_GET = [];

        $this->expectOutputString(json_encode([
            'status' => 400,
            'data' => ['error' => 'Invalid or missing CEP']
        ]));

        $this->cepController->getCepData();
    }

    public function test_constructor_injects_cep_service_dependency(): void
    {
        $mockCepService = $this->createMock(CepServiceInterface::class);
        
        $controller = new CepController($mockCepService);
        
        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('cepService');
        $property->setAccessible(true);
        
        $this->assertSame($mockCepService, $property->getValue($controller));
    }
}
