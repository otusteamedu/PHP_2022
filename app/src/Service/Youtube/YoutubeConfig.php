<?php

namespace App\Service\Youtube;

class YoutubeConfig
{
    public function __construct(
        private readonly string $apiKey
    )
    {
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
