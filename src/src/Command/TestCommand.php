<?php

declare(strict_types=1);

namespace App\Command;

use App\Provider\ProviderFactory;

class TestCommand implements CommandInterface
{
    public function __construct(private array $config)
    {
    }

    public function execute(): void
    {
        $provider = ProviderFactory::createProvider($this->config);
        $provider->testConnection();
    }
}