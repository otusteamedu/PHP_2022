<?php

declare(strict_types=1);

namespace App\Command\Table;

use App\Command\CommandInterface;
use App\Provider\ProviderFactory;

class PrintCommand implements CommandInterface
{
    public function __construct(private array $config, private array $params)
    {
    }

    public function execute(): void
    {
        $provider = ProviderFactory::createProvider($this->config);
        $provider->printTable($this->params[0]);
    }
}