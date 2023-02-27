<?php

namespace App\Provider;

use App\Helper\PrintHelper;
use App\Provider\Elastic\Command\Index\CreateIndexCommand;
use App\Provider\Elastic\Command\Index\DeleteIndexCommand;
use App\Provider\Elastic\Command\Index\GetIndexCommand;
use App\Provider\Elastic\Command\Search\SearchCommand as ElasticSearchCommand;
use App\Provider\Elastic\DTO\ConnectionParamsDTO;
use App\Provider\Elastic\Factory\ClientFactory;
use App\Provider\Elastic\Query\GetVersionQuery;
use App\Provider\Elastic\Query\Index\CreateIndexQuery;
use App\Provider\Elastic\Query\Index\DeleteIndexQuery;
use App\Provider\Elastic\Query\Index\GetIndexQuery;
use App\Provider\Elastic\Query\Search\SearchQuery;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use JsonException;

class ElasticProvider implements ProviderInterface
{
    private Client $client;

    public function __construct($config)
    {
        $connectionParams = new ConnectionParamsDTO($config);
        $this->client = ClientFactory::create($connectionParams);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function createTable(...$params): void
    {
        $command = new CreateIndexCommand(...$params);
        $query = new CreateIndexQuery($command, $this->client);
        $query->execute();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function deleteTable(string $tableName): void
    {
        $command = new DeleteIndexCommand($tableName);
        $query = new DeleteIndexQuery($command, $this->client);
        $query->execute();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException|JsonException
     */
    public function getTable(string $tableName): array
    {
        $command = new GetIndexCommand($tableName);
        $query = new GetIndexQuery($command, $this->client);
        $query->execute();
        return $query->getResult();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws Exception
     */
    public function search(array $params): array
    {
        $command = new ElasticSearchCommand(...$params);
        $query = new SearchQuery($command, $this->client);
        $query->execute();
        return $query->getSearchResult();
    }


    public function testConnection(): void
    {
        $query = new GetVersionQuery($this->client);
        $query->execute();
        $version = $query->getVersion();
        echo 'Connected to ElasticSearch version ' . $version['number'] . PHP_EOL;
    }

    /**
     * @throws JsonException
     */
    public function printSearchResult(array $result): void
    {
        printf("Total docs: %d\n", $result['hits']['total']['value']);
        printf("Max score : %.4f\n", $result['hits']['max_score']);
        printf("Took      : %d ms\n", $result['took']);

        if (!empty($result['hits']['hits'])) {
            $printHelper = new PrintHelper();
            $printHelper->printNestedArray($result['hits']['hits'], '_source');
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException|JsonException
     */
    public function printTable(string $tableName): void
    {
        print_r($this->getTable($tableName));
    }
}