<?php

namespace KonstantinDmitrienko\App\Models;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;
use KonstantinDmitrienko\App\Interfaces\StorageInterface;

class ElasticSearch implements StorageInterface
{
    /**
     * @var Client
     */
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->setHosts(['elastic_search:' . getenv('ES_PORT')])->build();

        try {
            $this->client->search([
                'index' => YoutubeChannel::CHANNEL_INDEX,
                'body'  => [
                    'query' => [
                        'match' => [
                            'query' => YoutubeChannel::CHANNEL_INDEX
                        ]
                    ]
                ]
            ]);
        } catch (Exception $e) {
            // Create base indexes
            $this->client->index(['index' => YoutubeChannel::CHANNEL_INDEX, 'body' => []]);
            $this->client->index(['index' => YoutubeChannel::VIDEO_INDEX, 'body' => []]);
        }
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function search(array $params): array
    {
        return $this->client->search($params);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function add(array $data): array
    {
        return $this->client->index($data);
    }

    /**
     * @param string $index
     * @param string $id
     *
     * @return array
     */
    public function delete(string $index, string $id): array
    {
        return $this->client->delete(['index' => $index, 'id' => $id]);
    }

    /**
     * @param string $name
     *
     * @return array
     */
    protected function searchYoutubeChannel(string $name): array
    {
        return $this->search([
            'index' => YoutubeChannel::CHANNEL_INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'query' => $name
                    ]
                ]
            ]
        ]);
    }

    /**
     * @param array $video
     *
     * @return array|void
     */
    protected function saveYoutubeVideo(array $video)
    {
        return $this->add([
            'index' => YoutubeChannel::VIDEO_INDEX,
            'id'    => $video['ID'],
            'body'  => $video,
        ]);
    }

    /**
     * @param array $channelInfo
     *
     * @return array|void
     */
    protected function saveYoutubeChannel(array $channelInfo)
    {
        return $this->add([
            'index' => YoutubeChannel::CHANNEL_INDEX,
            'id'    => $channelInfo['ID'],
            'body'  => $channelInfo,
        ]);
    }

    /**
     * @return array
     */
    protected function getAllChannelsInfo(): array
    {
        $cache    = $this->search(['index' => YoutubeChannel::CHANNEL_INDEX, 'size' => 1000]);
        $channels = [];

        if ($cache['hits']['hits']) {
            foreach ($cache['hits']['hits'] as $hit) {
                if ($hit['_source']) {
                    $channels[] = $hit['_source'];
                }
            }
        }

        return $channels;
    }

    /**
     * @param string $channelID
     *
     * @return array
     */
    protected function getVideosFromChannel(string $channelID): array
    {
        $cache = $this->search([
            'index' => YoutubeChannel::VIDEO_INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'ChannelID' => $channelID
                    ]
                ]
            ]
        ]);

        $videos = [];
        if ($cache['hits']['total']['value']) {
            foreach ($cache['hits']['hits'] as $hit) {
                if ($hit['_source']) {
                    $videos[] = $hit['_source'];
                }
            }
        }

        return $videos;
    }
}
