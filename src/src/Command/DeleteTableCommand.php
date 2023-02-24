<?php

declare(strict_types=1);

namespace App\Command;

use App\Providers\Elastic\Command\Index\DeleteIndexCommand;
use App\Providers\Elastic\DTO\ConnectionParamsDTO;
use App\Providers\Elastic\Factory\ClientFactory;
use App\Providers\Elastic\Query\Index\DeleteIndexQuery;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;

class DeleteTableCommand implements CommandInterface
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
            $command = new DeleteIndexCommand($this->params[0], $client);
            $query = new DeleteIndexQuery($command);
            $query->execute();
        } else {
            echo 'Check db provider & connection config\n';
        }
    }
}