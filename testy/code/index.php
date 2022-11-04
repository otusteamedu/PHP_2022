<?php

declare(strict_types=1);


use Elasticsearch\ClientBuilder;
use Mapaxa\ElasticSearch\App\App;

require_once __DIR__ . '/vendor/autoload.php';




$app = new App();
$app->run();

//    $client = ClientBuilder::create()->setHosts(['http://elasticsearch6:9200'])->build();
//
//    /**
//     * Index a document
//     */
//    $params = [
//        'index' => 'bookshoptest',
//        'type' => 'books',
//        'body' => ['name' => 'Wendell Adriel', 'login' => 'wendell_adriel']
//    ];
//
//    $response = $client->index($params);
//   // var_dump('<pre>', $response, '</pre>', '<hr>');
//
//
//    /**
//     * Searching a document
//     */
//    $params = [
//        'index' => 'bookshoptest',
//        'type' => 'books',
//        'body' => [
//            'query' => [
//                'match' => [
//                    'login' => 'wendell_adriel'
//                ]
//            ]
//        ]
//    ];
//
//    $response = $client->search($params);
//    var_dump('<pre>', $response, '</pre>', '<hr>');
