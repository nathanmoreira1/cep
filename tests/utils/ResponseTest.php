<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Utils\Response;

class ResponseTest extends TestCase
{
    public function testCreateResponse(): void
    {
        // Test data
        $data = ['message' => 'Success'];
        $statusCode = 200;

        // Capture the response
        $response = Response::createResponse($statusCode, $data);

        // Test the status code
        $this->assertEquals($statusCode, http_response_code());

        // Test the JSON response structure
        $this->assertJson($response);
        
        // Test the response content
        $decodedResponse = json_decode($response, true);
        $this->assertEquals($data, $decodedResponse);
    }

    public function testCreateResponseWithDifferentStatusCode(): void
    {
        $data = ['message' => 'Not Found'];
        $statusCode = 404;

        $response = Response::createResponse($statusCode, $data);

        $this->assertEquals($statusCode, http_response_code());
        $this->assertJson($response);

        $decodedResponse = json_decode($response, true);
        $this->assertEquals($data, $decodedResponse);
    }
}