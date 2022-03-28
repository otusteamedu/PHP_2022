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

        // Define service object for making API requests.
        $this->service = new Google_Service_YouTube($this->client);
    }

    public function getChannelInfo($request): array
    {
        try {
            $response = $this->service->channels->listChannels(
                'snippet,contentDetails,statistics',
                ['forUsername' => $request['youtube']['name']]
            );
        } catch (RuntimeException $e) {
            throw new RuntimeException('Error. Data about channel is not found.');
        }

        return [
            'ID'          => $response['items'][0]['id'],
            'Title'       => $response['items'][0]['snippet']['title'],
            'Description' => $response['items'][0]['snippet']['description'],
        ];
    }
}
