<?php

namespace Rs\Rs;

use Elastic\Elasticsearch\ClientBuilder;
use GuzzleHttp\Client as HttpClient;

class App
{

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
}