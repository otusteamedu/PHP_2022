<?php

declare(strict_types=1);

namespace Src\Domain\UseCases;

use Src\Domain\Contracts\HttpGateway\HttpClient;
use Src\Application\Exceptions\WorldMxRecordsValidationException;

final class WorldMxRecordsValidation
{
    /**
     * @var HttpClient
     */
    private HttpClient $http_client;

    /**
     * @param HttpClient $http_client
     */
    public function __construct(HttpClient $http_client)
    {
        $this->http_client = $http_client;
    }

    /**
     * @param string $email_hostname
     * @return void
     * @throws WorldMxRecordsValidationException
     */
    public function validate(string $email_hostname): void
    {
        try {
            $response = $this->http_client
                ->send(
                    http_method: 'GET',
                    base_uri: 'https://dns.google/',
                    uri: 'resolve?name=' . $email_hostname . '&type=MX'
                )
                ->getBody()
                ->getContents();

            $response_to_array = json_decode(json: $response, associative: true);

            if (isset($response_to_array['Status']) && (int)$response_to_array['Status'] !== 0) {
                throw new WorldMxRecordsValidationException(message: 'world_mx_record_errors');
            }

            if (!isset($response_to_array['Answer'])) {
                throw new WorldMxRecordsValidationException(message: 'world_mx_record_errors');
            } else {
                foreach ($response_to_array['Answer'] as $answer) {
                    if ((int)$answer['type'] !== 15) {
                        throw new WorldMxRecordsValidationException(message: 'world_mx_record_errors');
                    }
                }
            }
        } catch (\Throwable $exception) {
            throw new WorldMxRecordsValidationException(
                message: 'Method: ' . __METHOD__ . PHP_EOL
                . 'Error: ' . $exception->getMessage()
            );
        }
    }
}
