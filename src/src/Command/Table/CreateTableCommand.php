<?php

declare(strict_types=1);

namespace App\Command\Table;

use App\Command\CommandInterface;
use App\Provider\Elastic\Command\Index\CreateIndexCommand;
use App\Provider\Elastic\DTO\ConnectionParamsDTO;
use App\Provider\Elastic\Factory\ClientFactory;
use App\Provider\Elastic\Query\Index\CreateIndexQuery;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;

class CreateTableCommand implements CommandInterface
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
            $command = new CreateIndexCommand(
                [
                    'index' => $this->params[0],
                    'properties' => [
                        [
                            'name' => $this->params[1],
                            'type' => $this->params[2],
                        ]
                    ],
                ],
                $client
            );
            $query = new CreateIndexQuery($command);
            $query->execute();
        } else {
            echo 'Check db provider & connection config\n';
        }
    }
}