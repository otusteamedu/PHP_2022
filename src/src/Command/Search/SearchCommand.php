<?php

declare(strict_types=1);

namespace App\Command\Search;

use App\Command\CommandInterface;
use App\Provider\Elastic\Command\Search\SearchCommand as ElasticSearchCommand;
use App\Provider\Elastic\DTO\ConnectionParamsDTO;
use App\Provider\Elastic\Factory\ClientFactory;
use App\Provider\Elastic\Query\Search\SearchQuery;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;

class SearchCommand implements CommandInterface
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
     * @throws Exception
     */
    public function execute(): void
    {
        $provider = ($this->config)['db']['provider'] ?? null;
        $elasticConf = ($this->config)['elastic'] ?? null;
        if ($provider === 'elastic' && !empty($elasticConf)) {
            $connectionParams = new ConnectionParamsDTO($elasticConf);
            $client = ClientFactory::create($connectionParams);
            $command = new ElasticSearchCommand(
                $this->params[0],
                $this->params[1],
                $this->params[2],
                $client);
            $query = new SearchQuery($command);
            $query->execute();
        } else {
            echo 'Check db provider & connection config\n';
        }
    }
}