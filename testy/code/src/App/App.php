<?php

declare(strict_types=1);

namespace Mapaxa\ElasticSearch\App;

use Mapaxa\ElasticSearch\Client\ElasticsearchClient;
use Mapaxa\ElasticSearch\InputParams\InputParams;
use Mapaxa\ElasticSearch\Renderer\Renderer;
use Mapaxa\ElasticSearch\Router;
use Mapaxa\ElasticSearch\HandBook\HttpStatusHandbook;
use Mapaxa\ElasticSearch\Service\Http\Response;


class App
{
    /** @var ElasticsearchClient */
    private $client;

    /** @var array */
    private $inputParams;

    /** @var Renderer */
    private $renderer;


    public function __construct()
    {
        $this->client = new ElasticsearchClient();
        $this->inputParams = (new InputParams())->getParams();
        $this->renderer = new Renderer();
    }

    public function run(): void
    {
        $result = $this->client->search($this->inputParams);
        $this->renderer->render($result);
    }
}