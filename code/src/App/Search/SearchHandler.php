<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\App\Search;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Nikcrazy37\Hw10\Config;
use Nikcrazy37\Hw10\Exception\AppException;

class SearchHandler
{
    private Client $client;
    private SearchBuilder $query;

    /**
     * @throws AppException
     */
    public function __construct()
    {
        try {
            $this->client = ClientBuilder::create()
                ->setHosts([Config::getOption("host")])
                ->build();
        } catch (AuthenticationException $e) {
            throw new AppException($e->getMessage());
        }

        $this->query = new SearchBuilder();
    }

    /**
     * @param $param
     * @return array
     * @throws AppException
     */
    public function run($param): array
    {
        $this->buildQuery($param);

        try {
            $search = $this->client->search($this->query->getQuery());
        } catch (ClientResponseException|ServerResponseException $e) {
            throw new AppException($e->getMessage());
        }

        return $search->asArray();
    }

    /**
     * @param $param
     * @return void
     */
    private function buildQuery($param): void
    {
        if (empty($param)) {
            $this->query->setAll();

            return;
        }

        array_walk($param, function ($value, $key) {
            $key = ucfirst($key);
            $method = "set$key";
            $this->query->$method($value);
        });
    }
}