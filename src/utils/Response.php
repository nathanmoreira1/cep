<?php

namespace App\Utils;

class Response
{
    /**
     * Returns an HTTP response with a status code and data in JSON.
     *
     * @param int $statusCode The HTTP status code.
     * @param array $data The data to be sent in the response.
     * @return string The JSON response.
     */
    public static function createResponse(int $statusCode, array $data): string
    {
        http_response_code($statusCode);
        return json_encode($data);
    }
}
