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
    protected Client $client;

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
     * @param $data
     *
     * @return void
     */
    public function add($data): array
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
     * @param $name
     *
     * @return array
     */
    public function searchYoutubeChannel($name): array
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
    public function saveYoutubeVideo(array $video)
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
    public function saveYoutubeChannel(array $channelInfo)
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
    public function getAllChannelsInfo(): array
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
     * @param $channelID
     *
     * @return array
     */
    public function getVideosFromChannel($channelID): array
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
