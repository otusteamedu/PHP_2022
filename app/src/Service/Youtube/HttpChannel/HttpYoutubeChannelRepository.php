<?php

namespace App\Service\Youtube\HttpChannel;

use App\Entity\YoutubeChannel;
use Exception;
use App\Service\Youtube\YoutubeConfig;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpYoutubeChannelRepository
{
    const URL = 'https://www.googleapis.com/youtube/v3/channels';

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

    public function requestFindByIdOrFail(string $id, string $part): ResponseInterface
    {
        $url = self::URL;
        $url .= '?part=' . $part;
        $url .= '&id=' . $id;
        $url .= '&key=' . $this->apiKey;
        $response = $this->client->request('GET', $url);
        $content = $response->toArray();
        $status = $response->getStatusCode();
        if ($status !== Response::HTTP_OK) {
            throw new Exception($content['error']['message'], $status);
        }
        if ($content['pageInfo']['totalResults'] === 0) {
            throw new Exception(
                "The Channel id $id not found",
                Response::HTTP_NOT_FOUND,
                null,
            );
        }
        return $response;
    }

    public function findByIdWithSnippetOrFail(string $id): YoutubeChannel
    {
        $response = $this->requestFindByIdOrFail($id, 'snippet');
        $content = $response->toArray();
        $channel = new YoutubeChannel;
        $channel->setId($content['items'][0]['id']);
        $channel->setTitle($content['items'][0]['snippet']['title']);
        return $channel;
    }
}