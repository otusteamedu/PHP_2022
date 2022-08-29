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

    const OTUS_SHOP="otus-shop";
    const HOST='http://elastic:9200';

    /**
     * @var array
     */
    private array $query;

    /**
     * @var Elasticsearch
     */
    private Elasticsearch $response;

    /**
     * @param initFilterDto $dto
     * @return $this
     */
    public function buildQuery(initFilterDto $dto): ElasticFindBook
    {
        $query=[
            'index' => self::OTUS_SHOP,
            'body' => [
                "query"=>[
                    "bool"=>[

                    ]
                ]
            ]
        ];

        if($title=$dto->getTitle()){
            $query['body']['query']['bool']['must'][]['match']['title']=[
                "query"=>$title,
                "fuzziness"=>"auto",
            ];
        }

        if($sku=$dto->getSku()){
            $query['body']['query']['bool']['must'][]['term']['sku']=[
                "value"=>$sku,
            ];
        }

        if($category=$dto->getCategory()){
            $query['body']['query']['bool']['must'][]['term']['category']=[
                "value"=>$category,
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
            ->setHosts([self::HOST])
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
