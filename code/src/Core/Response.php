<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp\Core;

use Exception;

class Response
{
    public const SERVER_SUCCESS_REQUEST = 200;
    public const SERVER_BAD_REQUEST = 400;
    public const SERVER_REQUESTS = [
        self::SERVER_SUCCESS_REQUEST,
        self::SERVER_BAD_REQUEST
    ];

    private ?string $data;

    public function setData(?string $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setCode(int $code): self
    {
        if (!in_array($code, self::SERVER_REQUESTS)) {
            throw new Exception('sent by unknown request code');
        }

        http_response_code($code);

        return $this;
    }
}