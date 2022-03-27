<?php

namespace Elastic\App\Repository;

use Elastic\App\Model\ElasticModel;
use Elastic\App\Model\Factory\ElasticModelFactory;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use WS\Utils\Collections\CollectionFactory;

class ElasticRepository
{
    private const ELASTIC_HOST = 'elasticsearch:9200';

    private Client $client;
    private ElasticModelFactory $modelFactory;

    public function __construct(ElasticModelFactory $modelFactory)
    {
        $this->client = ClientBuilder::create()->setHosts([self::ELASTIC_HOST])->build();
        $this->modelFactory = $modelFactory;
    }

    public function createIndex(string $index): array
    {
        $result = $this->client->index(['index' => $index]);

        return [
            'result' => $result['result'],
            'index' => $result['_index'],
        ];
    }

    public function setDocument(ElasticModel $model): array
    {
        $result = $this->client->index([
            'index' => $model->getIndex(),
            'id' => $model->getId(),
            'body' => $model->toArray(),
        ]);

        return [
            'result' => $result['result'],
            'index' => $result['_index'],
            'id' => $result['_id'],
        ];
    }

    public function getDocument(string $index, string $id): ElasticModel
    {
        $data = $this->client->get([
           'index' => $index,
           'id' => $id,
        ]);

        $model = $this->modelFactory->get((string)$data['_index']);
        $model->setId((string)$data['_id']);
        $model->setData($data['_source']);

        return $model;
    }

    public function delete(string $index, string $id = ''): array
    {
        $result = $this->client->delete([
            'index' => $index,
            'id' => $id,
        ]);

        return [
            'result' => $result['result'],
            'index' => $result['_index'],
            'id' => $result['_id'],
        ];
    }

    /**
     * @param array $query
     * @return ElasticModel[]
     */
    public function search(array $query): array
    {
        $result = $this->client->search($query);

        return CollectionFactory::from($result['hits']['hits'])
            ->stream()
            ->map(function (array $elem) {
                $model = $this->modelFactory->get((string)$elem['_index']);
                $model->setId((string)$elem['_id']);
                $model->setData((array)$elem['_source']);

                return $model;
            })
            ->toArray();
    }
}
