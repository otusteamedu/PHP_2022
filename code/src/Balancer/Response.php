<?php

declare(strict_types=1);

namespace Masteritua\Src\Balancer;

class Response
{
    public function getHeaderCode($value = 400): void
    {
        http_response_code($value);
    }
}