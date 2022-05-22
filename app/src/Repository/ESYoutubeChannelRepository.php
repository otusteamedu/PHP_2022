<?php

namespace App\Repository;

use App\Entity\YoutubeChannel;
use Elastic\Elasticsearch\Client;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Elasticsearch\ElasticsearchService;
use App\Service\Youtube\Channel\YoutubeChannelRepositoryInterface;

class ESYoutubeChannelRepository implements YoutubeChannelRepositoryInterface
{
    const ES_INDEX = 'youtube_channel';
    private Client $client;

    public function __construct(ElasticsearchService $client)
    {
        $this->client = $client->getClient();
    }

    public function getAll(int $size = 100, int $offset = 0): array
    {
        $params = [
            'index' => self::ES_INDEX,
            'size' => $size,
            'offset' => $offset,
            'body' => [
                'query' => ['match_all' => (object)[]],
                '_source' => ['title', 'id'],
            ],
        ];
        $response = $this->client->search($params);
        return array_map(function (array $data) {
            $channel = new YoutubeChannel();
            $channel->setId($data['_source']['id']);
            $channel->setTitle($data['_source']['title']);
            return $channel;
        }, $response->asArray()['hits']['hits']);
    }

    public function getStatistics(int $size = 100, int $offset = 0): array
    {
        $params = [
            'index' => self::ES_INDEX,
            'size' => $size,
            'offset' => $offset,
            'body' => [
                'query' => ['match_all' => (object)[]],
                '_source' => ['title', 'id'],
                'aggs' => [
                    'rating' => [
                        'terms' => [
                            'field' => 'id.keyword',
                            'size' => $size,
                        ],
                        'aggs' => [
                            'amountLikes' => ['sum' => ['field' => 'videos.likeCount']],
                            'amountViews' => ['sum' => ['field' => 'videos.viewCount']],
                            'rating' => [
                                'bucket_script' => [
                                    'buckets_path' => [
                                        'amountLikes' => 'amountLikes',
                                        'amountViews' => 'amountViews'
                                    ],
                                    'script' => '(params.amountLikes / params.amountViews) * 1000'
                                ]
                            ],
                        ]
                    ]
                ]
            ],
        ];
        $response = $this->client->search($params);
        $content = $response->asArray();
        $buckets = $content['aggregations']['rating']['buckets'];
        $stats = [];
        foreach ($content['hits']['hits'] as $item) {
            $stats[$item['_source']['id']] = [
                'id' => $item['_source']['id'],
                'title' => $item['_source']['title']
            ];
        }
        foreach ($buckets as $item) {
            $stats[$item['key']]['amountLikes'] = (int)$item['amountLikes']['value'];
            $stats[$item['key']]['amountViews'] = (int)$item['amountViews']['value'];
            $stats[$item['key']]['rating'] = $item['rating']['value'];

        }
        return array_values($stats);
    }

    public function save(YoutubeChannel $channel): void
    {
        $params = [
            'index' => self::ES_INDEX,
            'id' => $channel->getId(),
            'body' => $channel->toArray(),
        ];
        $this->client->index($params);
    }

    public function delete(YoutubeChannel $channel): void
    {
        $params = [
            'index' => self::ES_INDEX,
            'id' => $channel->getId(),
        ];
        $this->client->delete($params);
    }

    public function findById(string $id): ?YoutubeChannel
    {
        $params = [
            'index' => self::ES_INDEX,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => ['match' => ['id' => $id]]
                    ]
                ]
            ]
        ];
        try {
            $response = $this->client->search($params);
        } catch (\Exception $e) {
            if ($e->getCode() === Response::HTTP_NOT_FOUND) {
                return null;
            }
            throw new \Exception($e->getMessage(), $e->getCode(), $e);
        }
        $body = $response->asArray();
        if ($body['hits']['total']['value'] === 0) {
            return null;
        }
        $channel = new YoutubeChannel;
        $channel->setId($body['hits']['hits'][0]['_id']);
        $channel->setTitle($body['hits']['hits'][0]['_source']['title']);
        return $channel;
    }

    public function syncVideos(YoutubeChannel $channel, array $videos)
    {
        $body = $channel->toArray();
        $body['videos'] = $videos;
        $params = [
            'index' => self::ES_INDEX,
            'id' => $channel->getId(),
            'body' => $body,
        ];
        $this->client->index($params);
    }
}
