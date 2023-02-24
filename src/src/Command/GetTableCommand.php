<?php

declare(strict_types=1);

namespace App\Command;

use App\Providers\Elastic\Command\Index\GetIndexCommand;
use App\Providers\Elastic\DTO\ConnectionParamsDTO;
use App\Providers\Elastic\Factory\ClientFactory;
use App\Providers\Elastic\Query\Index\GetIndexQuery;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;

class GetTableCommand implements CommandInterface
{
    /**
     * @param array $config
     * @param array $params
     */
    public function __construct(private array $config, private array $params)
    {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws Exception
     */
    public function execute(): void
    {
        $provider = ($this->config)['db']['provider'] ?? null;
        $elasticConf = ($this->config)['elastic'] ?? null;
        if ($provider === 'elastic' && !empty($elasticConf)) {
            $connectionParams = new ConnectionParamsDTO($elasticConf);
            $client = ClientFactory::create($connectionParams);
            $command = new GetIndexCommand($this->params[0], $client);
            $query = new GetIndexQuery($command);
            $query->execute();
        } else {
            echo 'Check db provider & connection config\n';
        }
    }
}