<?php

namespace Ppro\Hw12\Elasticsearch;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client as LibClient;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Ppro\Hw12\Helpers\AppContext;

class Client
{
    private LibClient $client;
    private AppContext $context;

    public function __construct(AppContext $context)
    {
        $this->context = $context;
        $this->client = ClientBuilder::create()
          ->setHosts([$this->context->getValue('host') . ':' . $this->context->getValue('port')])
          ->build();
    }

    /** Создание индекса
     * @param array $params
     * @return void
     */
    public function bulk(array $params): void
    {
        try {
            $response = $this->client->bulk($params);
        } catch (ClientResponseException $e) {
            // manage the 4xx error
            echo $e->getMessage();
        } catch (ServerResponseException $e) {
            // manage the 5xx error
            echo $e->getMessage();
        } catch (\Exception $e) {
            // eg. network error like NoNodeAvailableException
            echo $e->getMessage();
        }
        Response::setBulkResultToContext($this->context,$response);


    }

    /** Удаление индекса
     * @param string $indexName
     * @return void
     * @throws ServerResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     */
    public function deleteIndex(string $indexName):void
    {
        try {
            $response = $this->client->indices()->delete([
              'index' => $indexName
            ]);
        } catch (ClientResponseException $e) {
            if ($e->getCode() === 404)
                throw new \Exception('The document does not exist');
        }
        Response::setDeleteResultToContext($this->context,$response);
    }

    /** Фильтрация индекса
     * @param array $params
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function filterIndex(array $params):void
    {
        $response = $this->client->search($params);
        Response::setSearchResultToContext($this->context,$response);
    }

}