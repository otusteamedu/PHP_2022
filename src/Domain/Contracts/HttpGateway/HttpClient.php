<?php

declare(strict_types=1);

namespace Src\Domain\Contracts\HttpGateway;

interface HttpClient
{
    /**
     * @param string $http_method
     * @param string $base_uri
     * @param string $uri
     * @return $this
     */
    public function send(string $http_method, string $base_uri, string $uri): self;

    /**
     * @return $this
     */
    public function getBody(): self;

    /**
     * @return string
     */
    public function getContents(): string;
}
