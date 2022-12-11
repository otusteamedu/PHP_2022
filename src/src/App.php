<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

class App
{
    private ElasticsearchClient $elasticClient;

    private array $inputParams;

    private $render;


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