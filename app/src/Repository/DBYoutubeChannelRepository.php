<?php

namespace App\Repository;

use App\Entity\YoutubeChannel;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\Youtube\Channel\YoutubeChannelRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DBYoutubeChannelRepository extends ServiceEntityRepository implements YoutubeChannelRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YoutubeChannel::class);
    }

    public function remove(YoutubeChannel $channel): void
    {
        //
    }

    public function findById(string $id): ?YoutubeChannel
    {
        //
    }

    public function save(YoutubeChannel $channel): void
    {
        //
    }

    public function syncVideos(YoutubeChannel $channel, array $videos)
    {
        //
    }

    public function delete(YoutubeChannel $channel): void
    {
        //
    }

    public function getAll(int $size = 100, int $offset = 0): array
    {
        //
    }

    public function getStatistics(int $size = 100, int $offset = 0): array
    {
        // .
    }
}
