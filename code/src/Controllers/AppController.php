<?php

namespace KonstantinDmitrienko\App\Controllers;

use KonstantinDmitrienko\App\RequestValidator;

class AppController
{
    /**
     * @var YoutubeChannelController
     */
    protected YoutubeChannelController $youtubeChannelController;

    /**
     * @var ElasticSearchController
     */
    protected ElasticSearchController $elasticSearchController;

    /**
     * @var StatisticsController
     */
    private StatisticsController $statisticsController;

    public function __construct()
    {
        $this->elasticSearchController  = new ElasticSearchController();
        $this->youtubeChannelController = new YoutubeChannelController();
        $this->statisticsController     = new StatisticsController();
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function addYoutubeChannel(string $name): void
    {
        RequestValidator::checkChannelName($name);

        $cache = $this->elasticSearchController->searchYoutubeChannel($name);

        if ($cache['hits']['total']['value']) {
            $channelInfo = $cache['hits']['hits'][0]['_source'];
        } else {
            $channelInfo = $this->youtubeChannelController->getChannelInfo($name);
            $this->elasticSearchController->saveYoutubeChannel($channelInfo);
        }

        foreach ($this->youtubeChannelController->getChannelVideosInfo($channelInfo['ID']) as $video) {
            $this->elasticSearchController->saveYoutubeVideo($video);
        }
    }

    /**
     * @return array
     */
    public function getAllChannelsInfo(): array
    {
        return $this->statisticsController->getAllChannelsInfo($this->elasticSearchController);
    }

    /**
     * @return array
     */
    public function getTopRatedChannels(): array
    {
        return $this->statisticsController->getTopRatedChannels($this->elasticSearchController);
    }
}
