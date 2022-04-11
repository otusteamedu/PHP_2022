<?php

namespace KonstantinDmitrienko\App\Controllers;

use KonstantinDmitrienko\App\Models\ElasticSearch;

class ElasticSearchController extends ElasticSearch
{
    /**
     * @param string $name
     *
     * @return array
     */
    public function searchYoutubeChannel(string $name): array
    {
        return parent::searchYoutubeChannel($name);
    }

    /**
     * @param array $video
     *
     * @return array|void
     */
    public function saveYoutubeVideo(array $video)
    {
        return parent::saveYoutubeVideo($video);
    }

    /**
     * @param array $channelInfo
     *
     * @return array|void
     */
    public function saveYoutubeChannel(array $channelInfo)
    {
        return parent::saveYoutubeChannel($channelInfo);
    }

    /**
     * @return array
     */
    public function getAllChannelsInfo(): array
    {
        return parent::getAllChannelsInfo();
    }

    /**
     * @param string $channelID
     *
     * @return array
     */
    public function getVideosFromChannel(string $channelID): array
    {
        return parent::getVideosFromChannel($channelID);
    }
}
