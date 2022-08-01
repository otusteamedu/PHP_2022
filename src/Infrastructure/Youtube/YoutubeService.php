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


//    public function getChannel(string $id): ?ChannelProxy
//    {
//        $response = $this->service->channels->listChannels(
//            'snippet,contentDetails,statistics',
//            ['forUsername' => $id]
//        );
//
//
//        if (!$response['items']) {
//            $response = $this->service->channels->listChannels(
//                'snippet,contentDetails,statistics',
//                ['id' => $id]
//            );
//        }
//
//        if ($response['items'] && $response['items'][0]) {
//            $channel = $response['items'][0];
//
//            ['likes' => $likes, 'dislikes' => $dislikes] = $this->getVideosLikesAndDislikes($channel['id']);
//
//            return new ChannelProxy($channel, $likes, $dislikes);
//        }
//
//        return null;
//    }

    private function getVideosLikesAndDislikes(string $id): array
    {
        $likes = 0;
        $dislikes = 0;

        do {
            $videosInfo = $this->service->search->listSearch('snippet', ['channelId' => $id]);

            foreach ($videosInfo['items'] as $item) {
                if (!$item['id']['videoId']) {
                    continue;
                }

                $videoInfo = $this->service->videos->listVideos('snippet,statistics', ['id' => $item['id']['videoId']]);

                $likes += $videoInfo['items'][0]['statistics']['likeCount'];
                $dislikes += $videoInfo['items'][0]['statistics']['dislikeCount'];
            }
        } while ($videosInfo['nextPageToken']);

        return [
            'likes' => $likes,
            'dislikes' => $dislikes,
        ];
    }
}
