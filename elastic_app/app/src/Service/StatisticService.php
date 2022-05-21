<?php

namespace Elastic\App\Service;

use Elastic\App\Model\Channel;
use Elastic\App\Model\Video;
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

        $videos = $this->repository->search($query);

        return [
            'like' => $this->getLikeSum($videos),
            'dislike' => $this->getDislikeSum($videos),
        ];
    }

    public function getTopChannels(int $limit): array
    {
        $channels = $this->repository->search(['index' => 'channel']);

        $limit = count($channels) < $limit ? count($channels) : $limit;

        return CollectionFactory::from($channels)
            ->stream()
            ->sortByDesc(function (Channel $channel) {
                $channelLikes = $this->getChannelLikes($channel->getId());

                if (!$channelLikes['dislike']) {
                    return $channelLikes['like'];
                }

                return $channelLikes['like'] / $channelLikes['dislike'];
            })
            ->limit($limit)
            ->map(function (Channel $channel) {
                return $channel->getName();
            })
            ->toArray();
    }

    private function getLikeSum(array $videos): int
    {
        return (int)CollectionFactory::from($videos)
            ->stream()
            ->reduce(function (Video $video, $carry = null) {
                $carry += $video->getLikeCount();
                return $carry;
            });
    }

    private function getDislikeSum(array $videos): int
    {
        return (int)CollectionFactory::from($videos)
            ->stream()
            ->reduce(function (Video $video, $carry = null) {
                $carry += $video->getDislikeCount();
                return $carry;
            });
    }
}
