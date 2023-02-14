<?php

declare(strict_types=1);

namespace VeraAdzhieva\Hw10;

use Exception;
use VeraAdzhieva\Hw10\ElasticSearch\ElasticSearchClient;
use VeraAdzhieva\Hw10\Service\InputParams;
use VeraAdzhieva\Hw10\Service\Query;
use VeraAdzhieva\Hw10\Service\Response;

class App
{
    private ElasticSearchClient $client;

    public function __construct()
    {
        $this->client = new ElasticSearchClient();
    }
    /*
     * Запуск приложения.
     *
     * @return null|Exception
     */
    public function run()
    {
        try {
            $inputParams = new InputParams();

            $query = new Query($inputParams);
            $params = $query->getParam();

            $data = $this->client->search($params);

            $response = new Response();
            $headers = array('title', 'category', 'price','stock');
            $response->getResult($headers, $data);
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}