<?php

namespace App\Service\Youtube\HttpVideo;

use App\Service\Youtube\YoutubeConfig;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class HttpYoutubeVideoRepository
{
    const URL = 'https://www.googleapis.com/youtube/v3/videos';

    private string $apiKey;

    public function __construct(
        YoutubeConfig                        $config,
        private readonly HttpClientInterface $client,
    )
    {
        $this->apiKey = $config->getApiKey();
    }

    public function requestGetById(
        string $id,
        string $part
    ): ResponseInterface
    {
        $url = self::URL;
        $url .= "?key={$this->apiKey}";
        $url .= "&part=$part";
        $url .= "&id=$id";
        $url .= empty($pageToken) ? '' : "&pageToken=$pageToken";
        $response = $this->client->request('GET', $url);
        $content = $response->toArray();
        if ($response->getStatusCode() !== 200) {
            throw new Exception($content['error']['message'], $response->getStatusCode());
        }
        return $response;
    }

    public function getByIdsWithStatisticsSnippet(array $ids): array
    {
        $videos = [];
        $arIds = array_chunk($ids, 50);
        foreach ($arIds as $ids) {
            $strIds = implode(',', $ids);
            $response = $this->requestGetById($strIds, 'statistics,snippet');
            $content = $response->toArray();
            foreach ($content['items'] as $video) {
                $videos[] = [
                    'id' => $video['id'],
                    'title' => $video['snippet']['title'],
                    'viewCount' => (int)$video['statistics']['viewCount'],
                    'likeCount' => (int)$video['statistics']['likeCount'],
                ];
            }
        }
        return $videos;
    }
}