<?php

namespace App\Utils;

class Response
{
    /**
     * Envia uma resposta HTTP com código de status e dados em JSON.
     *
     * @param int $statusCode O código de status HTTP.
     * @param array $data Os dados a serem enviados na resposta.
     */
    public static function send(int $statusCode, array $data)
    {
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
}
