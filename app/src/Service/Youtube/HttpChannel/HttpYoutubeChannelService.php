<?php

namespace App\Service\Youtube\HttpChannel;

use App\Entity\YoutubeChannel;

class HttpYoutubeChannelService
{
    public function __construct(
        private readonly HttpYoutubeChannelRepository $channelRepository,
    )
    {
    }

    public function findByIdWithSnippetOrFail(string $id): YoutubeChannel
    {
        return $this->channelRepository->findByIdWithSnippetOrFail($id);
    }

}