<?php

namespace KonstantinDmitrienko\App;

// use Elastic\Elasticsearch\ClientBuilder;

use Elasticsearch\ClientBuilder;
use KonstantinDmitrienko\App\Interfaces\StorageInterface;

class ElasticSearch implements StorageInterface
{
    private $elasticSearchClient;
    private $hosts = [];

    public function __construct()
    {
        $this->hosts = ['elastic_search:' . getenv('ES_PORT')];
        $this->elasticSearchClient = ClientBuilder::create()->setHosts($this->hosts)->build();
    }

    /**
     * @param array $statement
     *
     * @return array
     */
    public function search(array $data): array
    {
        echo "<pre>";
        var_dump($data);

        // $response = $this->elasticSearchClient->getSource($data);

        $params['index'] = 'youtube_channel';
        $response = $this->elasticSearchClient->indices()->stats($params);
        echo "<pre>";
        print_r($response);
        exit;

        $params = [
            'index' => 'youtube_channel',
            'body'  => [
                'query' => [
                    'match' => [
                        'Title' => $data['title']
                    ]
                ]
            ]
        ];

        print_r($params);

        $response = $this->elasticSearchClient->search($params);

        print_r($response);
        exit;
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
    public function add($data): void
    {
        $this->elasticSearchClient->index($data);
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
