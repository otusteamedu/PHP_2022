<?php

namespace KonstantinDmitrienko\App;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use KonstantinDmitrienko\App\Interfaces\ElasticSearchInterface;

class ElasticSearch implements ElasticSearchInterface
{
    private $elasticSearchClient;

    private $hosts = [
        'elastic_search',
    ];
    private YoutubeApiHandler $youtubeApi;

    /**
     * @throws AuthenticationException
     */
    public function __construct($youtubeApi)
    {
        $this->elasticSearchClient = ClientBuilder::create()->setHosts(['elastic_search:' . getenv('ES_PORT')])->build();
        $this->youtubeApi = $youtubeApi;
    }

    /**
     * @param array $statement
     *
     * @return array
     */
    public function search(array $statement): array
    {
        // TODO: Implement search() method.
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    /**
     * @param $request
     *
     * @return bool
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function add($request): bool
    {
        $channelInfo = $this->youtubeApi->getChannelInfo($request);
        $cache = ['index' => 'youtube_channel', 'id' => $channelInfo['ID'], 'body' => $channelInfo];

        echo "<pre>";
        var_dump($cache);
        var_dump( $this->elasticSearchClient->index([$cache]) );
        exit;

        return true;
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
