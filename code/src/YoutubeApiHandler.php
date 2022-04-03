<?php

namespace KonstantinDmitrienko\App;

use Google_Client;
use Google_Service_YouTube;
use RuntimeException;

class YoutubeApiHandler
{
    protected Google_Client          $client;
    protected Google_Service_YouTube $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('YoutubeChannelsAnalyzer');
        $this->client->setDeveloperKey(getenv('YOUTUBE_API_KEY'));
        $this->service = new Google_Service_YouTube($this->client);
    }

    public function getChannelInfo($request): array
    {
        try {
            // Find channel by name
            $response = $this->service->channels->listChannels(
                'snippet,contentDetails,statistics',
                ['forUsername' => $request['youtube']['name']]
            );

            // Find channel by ID
            if (!$response['items']) {
                $response = $this->service->channels->listChannels(
                    'snippet,contentDetails,statistics',
                    ['id' => $request['youtube']['name']]
                );
            }
        } catch (RuntimeException $e) {
            throw new RuntimeException('Error. Data about channel is not found.');
        }

        if ($response['items']) {
            return [
                'ID'          => $response['items'][0]['id'],
                'Title'       => $response['items'][0]['snippet']['title'],
                'Description' => $response['items'][0]['snippet']['description'],
            ];
        }

        throw new RuntimeException('Error. Channel is not found by ID/Username.');
    }

    public function getChannelVideosInfo(string $channelID): array
    {
        try {
            $videos = [];
            do {
                $videosInfo = $this->service->search->listSearch('snippet', ['channelId' => $channelID]);

                foreach ($videosInfo['items'] as $item) {
                    $videoInfo = $this->service->videos->listVideos(
                        'snippet,statistics',
                        ['id' => $item['id']['videoId']]
                    );

                    $videos[] = [
                        'ID'          => $item['id']['videoId'],
                        'Title'       => $item['snippet']['title'],
                        'Description' => $item['snippet']['description'],
                        'Likes'       => $videoInfo['items'][0]['statistics']['likeCount'],
                        'Dislikes'    => $videoInfo['items'][0]['statistics']['dislikeCount'],
                    ];
                }
            } while ($videosInfo['nextPageToken']);

            return $videos;
        } catch (RuntimeException $e) {
            throw new RuntimeException('Error. Data about channel videos is not found.');
        }
    }
}
