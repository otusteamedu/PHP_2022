<?php

namespace App\Service\Youtube\Channel;

use App\Entity\YoutubeChannel;

interface YoutubeChannelRepositoryInterface
{
    public function save(YoutubeChannel $channel): void;

    public function delete(YoutubeChannel $channel): void;

    public function findById(string $id): ?YoutubeChannel;

    public function getAll(int $size = 100, int $offset = 0): array;

    public function getStatistics(int $size = 100, int $offset = 0): array;

    public function syncVideos(YoutubeChannel $channel, array $videos);
}