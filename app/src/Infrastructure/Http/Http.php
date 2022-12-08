<?php

declare(strict_types=1);

namespace App\Src\Infrastructure\Http;

final class Http
{
    /**
     * @return array
     */
    public function getRequestBody(): array
    {
        try {
            return json_decode(file_get_contents(filename: 'php://input'), associative: true);
        } catch (\Throwable $exception) {
            return [];
        }
    }

    /**
     * @param string|array $response
     * @param int $http_code
     * @param string $http_code_message
     * @return void
     */
    public function outputJsonResponse(string|array $response, int $http_code, string $http_code_message = ''): void
    {
        header(header: 'HTTP/1.1 ' . $http_code . ' ' . $http_code_message);
        header(header: 'Content-Type: application/json; charset=utf-8');

        $fp = fopen(filename: 'php://output', mode: 'w');

        fwrite($fp, json_encode(value: $response));

        fclose($fp);
    }
}
