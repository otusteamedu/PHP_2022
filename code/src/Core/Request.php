<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp\Core;

class Request
{
    private ?string $data;

    public function setData(?string $data): void
    {
        $this->data = $data;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function request($field = null)
    {
        $request = $_REQUEST;

        if (!$field) {
            return $request;
        }

        return $request[$field] ?? null;
    }
}