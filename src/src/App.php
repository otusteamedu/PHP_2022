<?php

declare(strict_types=1);

namespace Eliasjump\Elasticsearch;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class App
{
    private array $inputParams;
    private ElasticsearchClient $elsClient;
    private RenderHandler $renderHandler;


    public function __construct()
    {
        $this->inputParams = InputHandler::getParams();
        $this->elsClient = new ElasticsearchClient();
        $this->renderHandler = new RenderHandler();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function run(): void
    {
        $result = $this->elsClient->search($this->inputParams);
        $this->renderHandler->setRows($result);
        $this->renderHandler->render();
    }
}
