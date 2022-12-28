<?php

declare(strict_types=1);

namespace App\Application\Contract;

use Psr\Http\Message\ResponseInterface;

interface ApiClientInterface
{
    public function request(string $method, string $url, array $options = []): ResponseInterface;
}