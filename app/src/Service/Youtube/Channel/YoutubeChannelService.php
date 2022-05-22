<?php

namespace App\Service\Youtube\Channel;

use App\Entity\YoutubeChannel;

class YoutubeChannelService
{
    public function __construct(
        private readonly YoutubeChannelRepositoryInterface $channelRepository,
    )
    {
    }

    public function getAll(int $size = 100, int $offset = 0): array
    {
        return $this->channelRepository->getAll($size, $offset);
    }
    public function getStatistics(int $size = 100, int $offset = 0): array
    {
        return $this->channelRepository->getStatistics($size, $offset);
    }

    public function save(YoutubeChannel $channel): void
    {
        $this->channelRepository->save($channel);
    }

    public function findById(string $id): ?YoutubeChannel
    {
        return $this->channelRepository->findById($id);
    }

    public function existsById(string $id): bool
    {
        return $this->channelRepository->findById($id) instanceof YoutubeChannel;
    }

    public function syncVideos(YoutubeChannel $channel, array $videos): void
    {
        $this->channelRepository->syncVideos($channel, $videos);
    }

    public function delete(YoutubeChannel $channel): void
    {
        $this->channelRepository->delete($channel);
    }
}
