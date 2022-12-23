<?php

declare(strict_types=1);

namespace Src\Infrastructure;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Src\Domain\Contracts\HttpGateway\HttpClient;
use Psr\Http\Message\{ResponseInterface, StreamInterface};

final class HttpRequest implements HttpClient
{
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $http_response;

    /**
     * @var StreamInterface
     */
    private StreamInterface $http_response_body;

    /**
     * @param string $http_method
     * @param string $base_uri
     * @param string $uri
     * @return $this
     * @throws GuzzleException
     */
    public function send(string $http_method, string $base_uri, string $uri): self
    {
        $http_client = new Client(config: ['base_uri' => $base_uri]);

        $this->http_response = $http_client->request(method: $http_method, uri: $uri);

        return clone $this;
    }

    /**
     * @return $this
     */
    public function getBody(): self
    {
        $this->http_response_body = $this->http_response->getBody();

        return clone $this;
    }

    /**
     * @return string
     */
    public function getContents(): string
    {
        return $this->http_response_body->getContents();
    }
}
