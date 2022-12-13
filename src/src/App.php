<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

class App
{
    private ElasticsearchClient $elasticClient;

    private array $inputParams;

    private $renderHandler;


    public function __construct()
    {
        $this->inputParams = InputHandler::getParams();
        $this->client = new ElasticsearchClient();
        $this->renderHandler = new RenderHandler();
    }

    public function run(): void
    {
        $result = $this->client->search($this->inputParams);
        $this->renderHandler->setRows($result);
        $this->renderHandler->render();
    }
}