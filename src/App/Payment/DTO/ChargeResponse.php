<?php

declare(strict_types=1);

namespace App\App\Payment\DTO;

class ChargeResponse
{
    public int $httpCode;

    public string $content;
}