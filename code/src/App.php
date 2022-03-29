<?php

namespace KonstantinDmitrienko\App;

/**
 *
 */
class App
{
    protected View $view;
    protected ElasticSearch $storage;
    protected YoutubeApiHandler $youtubeApi;

    public function __construct() {
        $this->view       = new View();
        $this->youtubeApi = new YoutubeApiHandler();
        $this->storage    = new ElasticSearch();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $request = $_POST;

        if ($request) {
            RequestValidator::validate($request);
        } else {
            $this->view->showForm();
            return;
        }

        switch ($request['youtube']['action']) {
            case 'add_channel':
                RequestValidator::checkChannelName($request);
                $this->addYoutubeChannel($request);
                Response::success('Channel successfully added.');
                break;
        }

    }

    protected function addYoutubeChannel($request): void
    {
        // Find info in cache
        $cache = $this->storage->search($request);

        if ($cache['hits']['total']['value']) {
            $channelInfo = $cache['hits']['hits'][0]['_source']['info'];
            unset($cache);
        } else {
            $channelInfo = $this->youtubeApi->getChannelInfo($request);

            // Save channel to cache
            $this->storage->add([
                'index' => 'youtube_channel',
                'id'    => $channelInfo['ID'],
                'body'  => [
                    'query' => $request['youtube']['name'],
                    'info'  => $channelInfo,
                ]
            ]);
        }

        $videos = $this->youtubeApi->getChannelVideosInfo($channelInfo['ID']);

        print_r($videos);
        exit;
    }
}
