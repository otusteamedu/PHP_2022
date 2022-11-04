<?php
declare(strict_types=1);

namespace Mapaxa\ElasticSearch\Client;


use Elasticsearch\ClientBuilder;
use Mapaxa\ElasticSearch\Config\ConfigLoader;
use Mapaxa\ElasticSearch\QueryBuilder\QueryBuilder;
use Mapaxa\ElasticSearch\Entity\Book\BookFactory;

class ElasticsearchClient
{
    private $clientBuilder;
    private $queryBuilder;
    private $config;


    public function __construct()
    {
        $this->config = (new ConfigLoader())();
        $this->queryBuilder = new QueryBuilder();
        $this->clientBuilder = ClientBuilder::create()->setHosts([$this->config->getHost()])->build();
    }

    public function search(array $params): array
    {
        $params = $this->queryBuilder->build($params);
        $response = $this->clientBuilder->search($params);
        return $this->getResults($response);
    }

    private function getResults($response): array
    {
        $booksResponse = $response['hits']['hits'];
        $books = [];
        foreach ($booksResponse as $book) {
            $books[] = BookFactory::create(
                $book['_source']['sku'],
                $book['_source']['title'],
                (float)$book['_score'],
                $book['_source']['category'],
                $book['_source']['price'],
                $book['_source']['stock']
            );
        }

        return $books;
    }
}