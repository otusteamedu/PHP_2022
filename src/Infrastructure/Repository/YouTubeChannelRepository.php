<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Channel;
use App\Infrastructure\Youtube\YoutubeService;

class YouTubeChannelRepository implements ChannelRepositoryInterface
{
    public function __construct(
        private readonly YoutubeService $service,
    ) {}

    public function getChannel(string $id): ?Channel
    {
        $channel = $this->service->getChannel($id);

        if (!$channel) {
            return null;
        }

        $videos = $this->service->getVideos($channel->getId());

        $likes = 0;
        $dislikes = 0;

        foreach ($videos['items'] as $video) {
            if (!$video['id']['videoId']) {
                continue;
            }

            $stats = $this->service->getVideoStats($video['id']['videoId']);

            $likes += $stats['items'][0]['statistics']['likeCount'];
            $dislikes += $stats['items'][0]['statistics']['dislikeCount'];
        }

        return new Channel(
            $channel->getId(),
            $channel->getSnippet()->getTitle(),
            $channel->getSnippet()->getDescription(),
            $likes,
            $dislikes
        );
    }
}
