<?php

namespace Rs\Rs;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Rs\Rs\Dto\initFilterDto;

class ElasticFindBook
{

    /**
     * @var string|mixed
     */
    private string $index;

    /**
     * @var string|mixed
     */
    private string $host;

    /**
     * @var array
     */
    private array $query;

    /**
     * @var Elasticsearch
     */
    private Elasticsearch $response;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        list($index, $host)=Config::getConfig();
        $this->index=$index;
        $this->host=$host;
    }

    /**
     * @param initFilterDto $dto
     * @return $this
     */
    public function buildQuery(initFilterDto $dto): ElasticFindBook
    {
        $query=[
            'index' => $this->index,
            'body' => [
                "query"=>[
                    "bool"=>[

                    ]
                ]
            ]
        ];

        if(!is_null($dto->getTitle())){
            $query['body']['query']['bool']['must'][]['match']['title']=[
                "query"=>$dto->getTitle(),
                "fuzziness"=>"auto",
            ];
        }

        if(!is_null($dto->getSku())){
            $query['body']['query']['bool']['must'][]['term']['sku']=[
                "value"=>$dto->getSku(),
            ];
        }

        if(!is_null($dto->getCategory())){
            $query['body']['query']['bool']['must'][]['term']['category']=[
                "value"=>$dto->getCategory(),
            ];
        }

        if ($low=$dto->getLow()) {
            $query['body']['query']['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'gte' => $low
                    ]
                ]
            ];
        }

        if ($high=$dto->getHigh()) {
            $query['body']['query']['bool']['filter'][] = [
                'range' => [
                    'price' => [
                        'lte' => $high
                    ]
                ]
            ];
        }

        $query['body']['query']['bool']['filter'][] = [
            'nested' => [
                "path" => "stock",
                'query' => [
                    "bool"=>[
                        "filter"=>[
                            "range"=>[
                                "stock.stock"=>[
                                    "gte"=>1
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->setQuery($query);
        return $this;
    }

    /**
     * @return $this
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws AuthenticationException
     */
    public function search(): object
    {
        $client=$this->initClient();
        $response=$client->search($this->getQuery());
        $this->setResponse($response);
        return $this;
    }

    /**
     * @return Client
     * @throws AuthenticationException
     */
    private function initClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts([$this->host])
            ->build();
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @param array $query
     */
    public function setQuery(array $query): void
    {
        $this->query = $query;
    }

    /**
     * @return Elasticsearch
     */
    public function getResponse(): Elasticsearch
    {
        return $this->response;
    }


    /**
     * @param Elasticsearch $response
     * @return void
     */
    public function setResponse(Elasticsearch $response): void
    {
        $this->response = $response;
    }
}
