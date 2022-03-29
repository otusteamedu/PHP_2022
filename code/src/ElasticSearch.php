<?php

namespace KonstantinDmitrienko\App;

use Elasticsearch\ClientBuilder;
use KonstantinDmitrienko\App\Interfaces\StorageInterface;

class ElasticSearch implements StorageInterface
{
    private \Elasticsearch\Client $elasticSearchClient;
    private array                 $hosts;

    public function __construct()
    {
        $this->hosts = ['elastic_search:' . getenv('ES_PORT')];
        $this->elasticSearchClient = ClientBuilder::create()->setHosts($this->hosts)->build();
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function search(array $request): array
    {
        $params = [
            'index' => 'youtube_channel',
            'body'  => [
                'query' => [
                    'match' => [
                        'query' => $request['youtube']['name']
                    ]
                ]
            ]
        ];

        return $this->elasticSearchClient->search($params);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        // TODO: Implement getAll() method.
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
     * @param string $channelId
     *
     * @return void
     */
    public function delete(string $channelId): void
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return void
     */
    public function populate(): void
    {
        // TODO: Implement populate() method.
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        // TODO: Implement clear() method.
    }
}
