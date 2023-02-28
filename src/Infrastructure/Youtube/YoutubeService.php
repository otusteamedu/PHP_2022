<?php

namespace App\Infrastructure\Youtube;

use \Google\Client;
use \Google\Service\YouTube\Channel;
use Google_Client;
use Google_Service_YouTube;

class YoutubeService
{
    private Google_Service_YouTube $service;

    public function __construct(Google_Client $client)
    {
        $this->service = new Google_Service_YouTube($client);
    }


    public function getChannel(string $id): ?Channel
    {
        $response = $this->service->channels->listChannels(
            'snippet,contentDetails,statistics',
            ['forUsername' => $id]
        );

        if (!$response['items']) {
            $response = $this->service->channels->listChannels(
                'snippet,contentDetails,statistics',
                ['id' => $id]
            );
        }

        if ($response['items'] && $response['items'][0]) {
            return $response['items'][0];
        }

        return null;
    }


    public function getVideos(string $channelId): \Google\Service\YouTube\SearchListResponse
    {
        return $this->service->search->listSearch('snippet', ['channelId' => $channelId]);
    }


    public function getVideoStats(string $videoId): \Google\Service\YouTube\VideoListResponse
    {
        return $this->service->videos->listVideos('snippet,statistics', ['id' => $videoId]);
    }

}
