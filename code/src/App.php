<?php

namespace Study\Cinema;


use Study\Cinema\Elasticsearch\ElasticsearchClientBuilder;
use Study\Cinema\Service\ArgumentCreator;
use Study\Cinema\Service\QueryCreator;
use Study\Cinema\Service\Response;
use Study\Cinema\Exception\ArgumentException;

class App
{
    public function __construct()
    {
    }
    public function run()
    {

        try {

            $argsCreator = new ArgumentCreator();

            $queryCreator = new QueryCreator($argsCreator);
            $params = $queryCreator->getParam();

            $client = ElasticsearchClientBuilder::create();
            $data = $client->search($params);

            $response = new Response();
            $headers = array('Title', 'Category', 'Price','Stock');
            $columns = array('title', 'category', 'price', ['stock' => ['shop', 'stock']]);
            $response->getTableWithResult($headers, $columns, $data);

        }
        catch(ArgumentException $e) {
            echo $e->getMessage();
        }


    }




}
