<?php

namespace App\Service\Youtube\HttpPlaylist;

use Exception;
use App\Service\Youtube\YoutubeConfig;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpYoutubePlaylistRepository
{
    const URL = 'https://www.googleapis.com/youtube/v3/playlists';

    private string $apiKey;
    private HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $client,
        YoutubeConfig       $config,
    )
    {
        $this->client = $client;
        $this->apiKey = $config->getApiKey();
    }

    public function requestGetByChannelId(
        string $id,
        string $part,
        string $pageToken = null,
        int    $size = 50
    ): ResponseInterface
    {
        $url = self::URL;
        $url .= "?key={$this->apiKey}";
        $url .= "&part=$part";
        $url .= "&channelId=$id";
        $url .= "&maxResults={$size}";
        $url .= empty($pageToken) ? '' : "&pageToken=$pageToken";
        $response = $this->client->request('GET', $url);
        $content = $response->toArray();
        if ($response->getStatusCode() !== 200) {
            throw new Exception($content['error']['message'], $response->getStatusCode());
        }
        return $response;
    }

    public function getAllByChannelId(string $channelId): array
    {
        $playlists = [];
        $pageToken = null;
        do {
            $response = $this->requestGetByChannelId($channelId, 'id', $pageToken);
            $content = $response->toArray();
            $pageToken = $content['nextPageToken'] ?? null;
            array_push($playlists, ...$content['items']);
        } while ($pageToken !== null);
        return array_map(fn($p) => $p['id'], $playlists);
    }
}
