<?php

namespace App\Service\Youtube\HttpPlaylistItem;

use Exception;
use App\Service\Youtube\YoutubeConfig;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpYoutubePlaylistItemRepository
{
    const URL = 'https://www.googleapis.com/youtube/v3/playlistItems';

    private string $apiKey;

    public function __construct(
        YoutubeConfig                        $config,
        private readonly HttpClientInterface $client,
    )
    {
        $this->apiKey = $config->getApiKey();
    }

    public function requestGetByPlaylistId(
        string $id,
        string $part,
        string $pageToken = null,
        int    $size = 50
    ): ResponseInterface
    {
        $url = self::URL;
        $url .= "?key={$this->apiKey}";
        $url .= "&part=$part";
        $url .= "&playlistId=$id";
        $url .= "&maxResults={$size}";
        $url .= empty($pageToken) ? '' : "&pageToken=$pageToken";
        $response = $this->client->request('GET', $url);
        $content = $response->toArray();
        if ($response->getStatusCode() !== 200) {
            throw new Exception($content['error']['message'], $response->getStatusCode());
        }
        return $response;
    }

    public function getAllByPlaylistId(string $playlistId, string $part): array
    {
        $playlists = [];
        $pageToken = null;
        do {
            $response = $this->requestGetByPlaylistId($playlistId, $part, $pageToken);
            $content = $response->toArray();
            $pageToken = $content['nextPageToken'] ?? null;
            array_push($playlists, ...$content['items']);
        } while ($pageToken !== null);
        return array_map(fn($p) => $p['contentDetails']['videoId'], $playlists);
    }

    public function getAllContentByPlaylistIds(array $ids): array
    {
        $videos = [];
        foreach ($ids as $id) {
            array_push($videos, ...$this->getAllByPlaylistId($id, 'contentDetails'));
        }
        return $videos;
    }
}