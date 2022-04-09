<?php

namespace KonstantinDmitrienko\App\Controllers;

use JsonException;
use KonstantinDmitrienko\App\RequestValidator;
use KonstantinDmitrienko\App\Response;
use KonstantinDmitrienko\App\View;

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
     * @var View
     */
    protected View $view;

    /**
     * @var StatisticsController
     */
    private StatisticsController $statisticsController;

    public function __construct()
    {
        $this->elasticSearchController  = new ElasticSearchController();
        $this->youtubeChannelController = new YoutubeChannelController();
        $this->view                     = new View();
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

        Response::success('Channel successfully added.');
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function getAllChannelsInfo(): void
    {
        Response::success(json_encode(
            $this->statisticsController->getAllChannelsInfo($this->elasticSearchController),
            JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        ));
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function getTopRatedChannels(): void
    {
        Response::success(json_encode(
            $this->statisticsController->getTopRatedChannels($this->elasticSearchController),
            JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        ));
    }

    /**
     * @return void
     */
    public function showForm(): void
    {
        $this->view->showForm();
    }
}
