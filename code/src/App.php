<?php

namespace Study\Cinema;


use Study\Cinema\Elasticsearch\ElasticsearchClientBuilder;
use Study\Cinema\Service\ArgumentCreator;
use Study\Cinema\Service\QueryCreator;
use Study\Cinema\Service\Response;

class App
{
    public function __construct()
    {
    }
    public function run()
    {
        $argsCreator = new ArgumentCreator();
        if(!$argsCreator->validate())
        {
           echo $argsCreator->getMessage();
           return;
        }

        $queryCreator = new QueryCreator($argsCreator);
        $params = $queryCreator->getParam();

        $client = ElasticsearchClientBuilder::create();
        $data = $client->search($params);

        $response = new Response();
        $response->getTableWithResult($data);

    }




}
