<?php
declare(strict_types=1);

namespace Mapaxa\ElasticSearch\Client;


use Elasticsearch\ClientBuilder;
use Mapaxa\ElasticSearch\Config\ConfigLoader;
use Mapaxa\ElasticSearch\QueryBuilder\QueryBuilder;
use Mapaxa\ElasticSearch\ResponseToBookManager\ResponseToBookManager;

class ElasticsearchClient
{
    private $clientBuilder;
    private $queryBuilder;
    private $config;
    private $bookManager;


    public function __construct()
    {
        $this->config = (new ConfigLoader())();
        $this->queryBuilder = new QueryBuilder();
        $this->clientBuilder = ClientBuilder::create()->setHosts([$this->config->getHost()])->build();
        $this->bookManager = new ResponseToBookManager();
    }

    public function search(array $params): array
    {
        $params = $this->queryBuilder->build($params);
        $response = $this->clientBuilder->search($params);
        return $this->getResults($response);
    }

    private function getResults($response): array
    {
        return $this->bookManager->getBooksFromResponse($response);
    }
}