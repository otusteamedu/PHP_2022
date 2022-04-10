<?php

namespace KonstantinDmitrienko\App\Models;

use Google\Service\YouTube\SearchListResponse;
use Google\Service\YouTube\VideoListResponse;
use Google_Client;
use Google_Service_YouTube;
use RuntimeException;

class YoutubeChannel
{
    public const CHANNEL_INDEX = 'youtube_channel';
    public const VIDEO_INDEX   = 'youtube_video';

    /**
     * @var Google_Client
     */
    protected Google_Client $client;

    /**
     * @var Google_Service_YouTube
     */
    protected Google_Service_YouTube $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('YoutubeChannelsAnalyzer');
        $this->client->setDeveloperKey(getenv('YOUTUBE_API_KEY'));
        $this->service = new Google_Service_YouTube($this->client);
    }

    /**
     * @param string $name
     *
     * @return array
     */
    protected function getChannelInfo(string $name): array
    {
        // Find channel by name
        $response = $this->service->channels->listChannels(
            'snippet,contentDetails,statistics',
            ['forUsername' => $name]
        );

        // Find channel by ID
        if (!$response['items']) {
            $response = $this->service->channels->listChannels(
                'snippet,contentDetails,statistics',
                ['id' => $name]
            );
        }

        if ($response['items'] && $response['items'][0]) {
            return [
                'ID'          => $response['items'][0]['id'],
                'Title'       => $response['items'][0]['snippet']['title'],
                'Description' => $response['items'][0]['snippet']['description'],
            ];
        }

        throw new RuntimeException('Error. Data about channel is not found.');
    }

    /**
     * @param string $channelID
     *
     * @return SearchListResponse
     */
    protected function getBaseVideosInfo(string $channelID): SearchListResponse
    {
        try {
            return $this->service->search->listSearch('snippet', ['channelId' => $channelID]);
        } catch (RuntimeException $e) {
            throw new RuntimeException('Error. Data about channel videos is not found.');
        }
    }

    /**
     * @param string $videoID
     *
     * @return VideoListResponse
     */
    protected function getVideoInfo(string $videoID): VideoListResponse
    {
        try {
            return $this->service->videos->listVideos('snippet,statistics', ['id' => $videoID]);
        } catch (RuntimeException $e) {
            throw new RuntimeException('Error. Data about video is not found.');
        }
    }
}
