<?php

declare(strict_types=1);

namespace App\Command;

use App\Providers\Elastic\Command\GetVersionCommand;
use App\Providers\Elastic\DTO\ConnectionParamsDTO;
use App\Providers\Elastic\Factory\ClientFactory;
use App\Providers\Elastic\Query\GetVersionQuery;

class TestCommand implements CommandInterface
{
    /**
     * @param array $config
     */
    public function __construct(private array $config)
    {
    }

    public function execute(): void
    {
        $provider = ($this->config)['db']['provider'] ?? null;
        $elasticConf = ($this->config)['elastic'] ?? null;
        if ($provider === 'elastic' && !empty($elasticConf)) {
            $connectionParams = new ConnectionParamsDTO($elasticConf);
            $client = ClientFactory::create($connectionParams);
            $command = new GetVersionCommand($client);
            $query = new GetVersionQuery($command);
            echo 'Connected to ElasticSearch version ';
            $query->execute();
        } else {
            echo 'Check db provider & connection config\n';
        }
    }
}