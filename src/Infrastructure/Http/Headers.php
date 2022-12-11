<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

class Headers
{
    /**
     * Gets the server headers.
     *
     * Input server array is expected to match the format of $_SERVER.
     *
     * @param array $server
     *
     * @return array[]
     */
    public function getHeaders(array $server): array
    {
        $contentHeaders = [
            'CONTENT_LENGTH' => 'Content-Length',
            'CONTENT_MD5' => 'Content-MD5',
            'CONTENT_TYPE' => 'Content-Type',
        ];

        $headers = [];
        foreach ($server as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $name = $this->normalizeHeader(substr($key, 5));

                $headers[$name] = [$value];
            } elseif (isset($contentHeaders[$key])) {
                $name = $contentHeaders[$key];

                $headers[$name] = [$value];
            }
        }

        return $headers;
    }

    /**
     * Normalizers a header name.
     *
     * @param string $header
     *
     * @return string
     */
    private function normalizeHeader(string $header): string
    {
        return implode(
            '-',
            array_map(
                'ucfirst',
                explode('_', strtolower($header))
            )
        );
    }
}