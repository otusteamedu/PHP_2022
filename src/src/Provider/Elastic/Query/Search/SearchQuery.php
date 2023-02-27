<?php

declare(strict_types=1);

namespace App\Provider\Elastic\Query\Search;

use App\Provider\Elastic\Command\Search\SearchCommand;
use App\Provider\Elastic\Query\QueryInterface;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class SearchQuery implements QueryInterface
{
    private array $searchResult = [];

    public function __construct(private SearchCommand $command, private Client $client)
    {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function execute(): void
    {
        $response = $this->createSearchRequest();

        if ($response instanceof Promise) {
            echo 'Search in process... Status ' . $response->getState() . PHP_EOL;
        } else {
            $code = $response->getStatusCode();
            if ($code === 200) {
                $this->setSearchResult(['hits' => $response['hits']] + ['took' => $response['took']]);
            } else {
                echo 'Failure ' . $code . ' ' . $response->getReasonPhrase() . PHP_EOL;
            }
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function createSearchRequest(): Elasticsearch|Promise
    {
        return $this->client->search($this->command->buildParams());
    }

    /**
     * @return array
     */
    public function getSearchResult(): array
    {
        return $this->searchResult;
    }

    /**
     * @param array $searchResult
     */
    private function setSearchResult(array $searchResult): void
    {
        $this->searchResult = $searchResult;
    }

}
