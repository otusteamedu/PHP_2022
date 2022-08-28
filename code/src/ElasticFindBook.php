<?php

namespace Rs\Rs;

use Elastic\Elasticsearch\ClientBuilder;
use GuzzleHttp\Client as HttpClient;
use Rs\Rs\Dto\initFilterDto;

class ElasticFindBook
{

    const OTUS_SHOP="otus-shop";
    const HOST='http://elastic:9200';
    private array $query;

    /**
     * @return void
     */
    public function run():void
    {
        $client = ClientBuilder::create()
            ->setHosts(['http://elastic:9200'])
            ->build();
        $params = [
            'index' => "otus-shop",
            'body' => [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "match" => [
                                    "title" => [
                                        "query" => "терминfатор",
                                        "fuzziness" => "auto"
                                    ]
                                ]
                            ]
                        ],
                        "filter" => [
                            [
                                "range" => [
                                    "price" => [
                                        "gte" => 5000
                                    ]
                                ]
                            ],
                            [
                                "nested" => [
                                    "path" => "stock",
                                    "query" => [
                                        "bool" => [
                                            "filter" => [
                                                [
                                                    "match" => [
                                                        "stock.shop" => "Мира"
                                                    ]
                                                ],
                                                [
                                                    "range" => [
                                                        "stock.stock" => [
                                                            "gte" => 15
                                                        ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $response=$client->search($params);
        dump($response['hits']['hits']);
        echo 123;
    }

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

        $this->query=$query;
        return $this;
    }

    public function search(){
        $client=$this->initClient();
        $response=$client->search($this->query);
        dump($response['hits']['hits']);
        return 123;
    }

    private function initClient(){
        return ClientBuilder::create()
            ->setHosts([self::HOST])
            ->build();
    }

//php index.php -t "Терминаткр" -s "500-185" -c "Сад и огород" -l 1000 -h 2000
}//php index.php -t "qwe" -s "qwe" -c "qwe" -l "1" -h "2"
