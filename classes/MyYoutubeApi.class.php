<?php

/**
 * Work with Youtube API
 */

class MyYoutubeApi
{
    private $client = null;
    private $service = null;
    private const MAX_VIDEOS_LIMIT = 50;
    private const CONFIG_NAME = "mishaikon_bot.ini";

    public function __construct()
    {
        // read API key from config
        $configName = __DIR__ . '/../config/' . self::CONFIG_NAME;
        $config = parse_ini_file($configName, true);
        $apiKey = $config['youtube']['api_key'];
        if (!$apiKey) {
            throw new DomainException("apiKey is undefined");
        }

        $this->client = new Google_Client();
        $this->client->setApplicationName('API code samples');
        $this->client->setDeveloperKey($apiKey);

        if (!$this->client) {
            throw new DomainException("Cannot init API client");
        }

        // Define service object for making API requests.
        $this->service = new Google_Service_YouTube($this->client);

        if (!$this->service) {
            throw new DomainException("Cannot init API connection");
        }
    }


    /**
     * @return \Google\Service\YouTube\SearchListResponse
     */
    public function searchVideosList(string $query, int $limit): \Google\Service\YouTube\SearchListResponse
    {

        $queryParams = [
            'maxResults' => $limit,
            'q' => $query
        ];

        $response = $this->service->search->listSearch('snippet', $queryParams);

        return $response;
    }

    /**
     * @return array<string>
     */
    public function searchVideosUrlsList(string $query, int $limit): array
    {
        $list = $this->searchVideosList($query, $limit);

        /** @var Google\Service\YouTube\SearchResult $v */
        foreach ($list as $v) {
            $videoId = $v->getId()->getVideoId();
            if($videoId) {
                $urls[] = "https://www.youtube.com/watch?v=" . $videoId;
            }
        }

        return $urls;
    }

    /**
     * @param string $query
     * @return string
     */
    public function searchRandomVideo(string $query): string
    {
        $list = $this->searchVideosUrlsList($query, self::MAX_VIDEOS_LIMIT);
        $key = array_rand($list, 1);
        $url = $list[$key];

        return $url;
    }
}
