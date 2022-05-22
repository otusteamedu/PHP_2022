<?php

namespace App\Service\Youtube\HttpPlaylistItem;

class HttpYoutubePlaylistItemService
{
    public function __construct(
        private readonly HttpYoutubePlaylistItemRepository $repository
    )
    {
    }

    public function getAllContentByPlaylistIds(array $ids): array
    {
        return $this->repository->getAllContentByPlaylistIds($ids);
    }
}