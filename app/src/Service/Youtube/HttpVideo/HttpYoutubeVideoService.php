<?php

namespace App\Service\Youtube\HttpVideo;

use App\Entity\YoutubeChannel;
use App\Service\Youtube\HttpPlaylist\HttpYoutubePlaylistService;
use App\Service\Youtube\HttpPlaylistItem\HttpYoutubePlaylistItemService;

class HttpYoutubeVideoService
{
    public function __construct(
        private readonly HttpYoutubeVideoRepository     $repository,
        private readonly HttpYoutubePlaylistService     $playlistService,
        private readonly HttpYoutubePlaylistItemService $playlistItemService,
    )
    {
    }


    public function getVideosByChannel(YoutubeChannel $channel): array
    {
        $playlists = $this->playlistService->getAllByChannelId($channel);
        $playlistIds = array_slice($playlists, 0, 2);
        $playlistItems = $this->playlistItemService->getAllContentByPlaylistIds($playlistIds);
        $playlistItemIds = array_slice($playlistItems, 0, 20);
        return $this->repository->getByIdsWithStatisticsSnippet($playlistItemIds);
    }
}