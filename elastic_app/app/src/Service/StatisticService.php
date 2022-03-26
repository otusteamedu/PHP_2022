<?php

namespace Elastic\App\Service;

use Elastic\App\Repository\ElasticRepository;
use WS\Utils\Collections\CollectionFactory;

class StatisticService
{
    private ElasticRepository $repository;

    public function __construct(ElasticRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getChannelLikes(string $channelId): array
    {
        $query = [
            'index' => 'video',
            'body'  => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId
                    ]
                ]
            ]
        ];

        $result = $this->repository->search($query);

        $videos = (array)$result['hits']['hits'];

        return [
            'like' => $this->getLikeSum($videos),
            'dislike' => $this->getDislikeSum($videos),
        ];
    }

    public function getTopChannels(int $limit): array
    {
        $result = $this->repository->search(['index' => 'channel']);

        $channelIds = CollectionFactory::from((array)$result['hits']['hits'])
            ->stream()
            ->map(function (array $channel) {
                return (string)$channel['_id'];
            })
            ->toArray();

        $limit = count($channelIds) < $limit ? count($channelIds) : $limit;

        return CollectionFactory::from($channelIds)
            ->stream()
            ->sortByDesc(function (string $channelId) {
                $channelLikes = $this->getChannelLikes($channelId);

                if (!$channelLikes['dislike']) {
                    return $channelLikes['like'];
                }

                return $channelLikes['like'] / $channelLikes['dislike'];
            })
            ->limit($limit)
            ->toArray();
    }

    private function getLikeSum(array $videos): int
    {
        return (int)CollectionFactory::from($videos)
            ->stream()
            ->reduce(function (array $video, $carry = null) {
                $carry += (int)$video['_source']['likeCount'];
                return $carry;
            });
    }

    private function getDislikeSum(array $videos): int
    {
        return (int)CollectionFactory::from($videos)
            ->stream()
            ->reduce(function (array $video, $carry = null) {
                $carry += (int)$video['_source']['dislikeCount'];
                return $carry;
            });
    }
}
