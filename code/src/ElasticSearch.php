<?php

namespace KonstantinDmitrienko\App;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\ElasticsearchException;
use KonstantinDmitrienko\App\Interfaces\StorageInterface;

class ElasticSearch implements StorageInterface
{
    private Client $elasticSearchClient;

    public function __construct()
    {
        $this->elasticSearchClient = ClientBuilder::create()
            ->setHosts(['elastic_search:' . getenv('ES_PORT')])
            ->build();

        try {
            $this->elasticSearchClient->search([
                'index' => App::CHANNEL_INDEX,
                'body'  => [
                    'query' => [
                        'match' => [
                            'query' => App::CHANNEL_INDEX
                        ]
                    ]
                ]
            ]);
        } catch (ElasticSearchException $e) {
            // Create base indexes
            $this->elasticSearchClient->index(['index' => App::CHANNEL_INDEX, 'body' => []]);
            $this->elasticSearchClient->index(['index' => App::VIDEO_INDEX, 'body' => []]);
        }
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function search(array $params): array
    {
        return $this->elasticSearchClient->search($params);
    }

    /**
     * @param $data
     *
     * @return void
     */
    public function add($data): array
    {
        return $this->elasticSearchClient->index($data);
    }

    /**
     * @param string $index
     * @param string $id
     *
     * @return array
     */
    public function delete(string $index, string $id): array
    {
        return $this->elasticSearchClient->delete(['index' => $index, 'id' => $id]);
    }
}
