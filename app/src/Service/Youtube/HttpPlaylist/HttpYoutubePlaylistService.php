<?php

namespace App\Service\Youtube\HttpPlaylist;

use App\Entity\YoutubeChannel;

class HttpYoutubePlaylistService
{
    public function __construct(
        private readonly HttpYoutubePlaylistRepository $repository,
    )
    {
    }

    public function getAllByChannelId(YoutubeChannel $channel): array
    {
        return $this->repository->getAllByChannelId($channel->getId());
    }
}
