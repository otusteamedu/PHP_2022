<?php

declare(strict_types=1);

namespace App\Infrastructure\Client;

use App\Application\Contract\ApiClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class ApiClient implements ApiClientInterface
{
    private ClientInterface $client;

    public function __construct(array $config = [])
    {
        $this->client = new Client($config);
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        return $this->client->request($method, $url, $options);
    }
}