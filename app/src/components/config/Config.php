<?php

declare(strict_types=1);

namespace Nemizar\OtusShop\components\config;

class Config
{
    public function __construct(readonly string $host, readonly string $index)
    {
    }
}
