<?php

namespace app\models\Event\StoragesAdapters;

use app\storages\Elastic;
use Elastic\Elasticsearch\Client;

class EventElasticAdapter extends EventStorageAdapter {
    use Elastic;
    public Client $client;

    public function save(): bool
    {
        $params = [
            'index' => $this->prefix,
            'id'    => uniqid(),
            'body'  => [
                'priority' => $this->model->priority,
                'event' => $this->model->event,
                'conditions' => $this->model->conditions,
            ]
        ];
        return $this->client->index($params)->asBool();
    }


    public function deleteAll(): bool
    {
        $params = ['index' => $this->prefix];
        return $this->client->indices()->delete($params)->asBool();
    }

    public function find(array $conditions): array {
        $params = $this->getQueryParams($conditions);
        return $this->queryEvents($params);
    }

    private function getQueryParams(array $conditions, $limit = 0) {
        $filter = [];
        foreach ($conditions as $condKey => $condVal) {
            $filter[] = ['term' => ['conditions.'.$condKey => $condVal]];
        }
        $params = [
            'index' => $this->prefix,
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => $filter
                    ]
                ],
                'sort' => [
                    0 => ['priority' => 'desc']
                ],
            ]
        ];

        if ($limit > 0) $params['body']['size'] = $limit;

        return $params;
    }

    public function findPriorityOne($conditions): array {
        $params = $this->getQueryParams($conditions, 1);
        return $this->queryEvents($params);
    }

    private function queryEvents(array $params): array {
        try { // при отсутствии индекса считаем, что результатов нет
            $result = $this->client->search($params)->asArray();
        } catch (\Throwable $e) {
            if ($e->getCode() === 404) return [];
            else throw $e;
        }

        if (isset($result['hits']) && isset($result['hits']['hits'])) {
            return array_column($result['hits']['hits'], '_source');
        }
        return [];
    }
}
