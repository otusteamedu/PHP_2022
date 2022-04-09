<?php

namespace KonstantinDmitrienko\App\Controllers;

use KonstantinDmitrienko\App\Models\ElasticSearch;

class ElasticSearchController
{
    /**
     * @var ElasticSearch
     */
    protected ElasticSearch $elasticSearch;

    public function __construct()
    {
        $this->elasticSearch = new ElasticSearch();
    }

    /**
     * @param $name
     *
     * @return array
     */
    public function searchYoutubeChannel($name): array
    {
        return $this->elasticSearch->searchYoutubeChannel($name);
    }

    /**
     * @param array $video
     *
     * @return array|void
     */
    public function saveYoutubeVideo(array $video)
    {
        return $this->elasticSearch->saveYoutubeVideo($video);
    }

    /**
     * @param array $channelInfo
     *
     * @return array|void
     */
    public function saveYoutubeChannel(array $channelInfo)
    {
        return $this->elasticSearch->saveYoutubeChannel($channelInfo);
    }

    /**
     * @return array
     */
    public function getAllChannelsInfo(): array
    {
        return $this->elasticSearch->getAllChannelsInfo();
    }

    /**
     * @param $channelID
     *
     * @return array
     */
    public function getVideosFromChannel($channelID): array
    {
        return $this->elasticSearch->getVideosFromChannel($channelID);
    }
}
