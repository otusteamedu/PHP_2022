<?php

namespace App\Event;

use Psr\Http\Message\ResponseInterface;
use Symfony\Contracts\EventDispatcher\Event;

class HttpRequestSentToBank extends Event
{
    public function __construct(
        private readonly string $bankName,
        private readonly string $bankUuid,
        private readonly ResponseInterface $response
    ) {
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function getBankName(): string
    {
        return $this->bankName;
    }

    public function getBankUuid(): string
    {
        return $this->bankUuid;
    }
}
