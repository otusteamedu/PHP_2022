<?php

declare(strict_types=1);

namespace App\Command\Search;

use App\Command\CommandInterface;
use App\Provider\ProviderFactory;

class SearchCommand implements CommandInterface
{
    public function __construct(private array $config, private array $params)
    {
    }

    public function execute(): void
    {
        $provider = ProviderFactory::createProvider($this->config);
        $result = $provider->search($this->params);
        $provider->printSearchResult($result);
    }
}
