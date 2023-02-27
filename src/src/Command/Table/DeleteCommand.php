<?php

declare(strict_types=1);

namespace App\Command\Table;

use App\Command\CommandInterface;
use App\Provider\ProviderFactory;

class DeleteCommand implements CommandInterface
{
    public function __construct(private array $config, private array $params)
    {
    }

    public function execute(): void
    {
        $provider = ProviderFactory::createProvider($this->config);
        $provider->deleteTable($this->params[0]);
    }
}