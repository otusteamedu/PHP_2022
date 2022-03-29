<?php

namespace KonstantinDmitrienko\App;

use Elastic\Elasticsearch\Exception\AuthenticationException;

/**
 *
 */
class App
{
    protected string $string = '';
    protected object $view;
    protected ElasticSearch $storage;
    protected YoutubeApiHandler $youtubeApi;

    /**
     * @throws AuthenticationException
     */
    public function __construct() {
        $this->view = new View();
        $this->youtubeApi = new YoutubeApiHandler();
        $this->storage = new ElasticSearch();
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

                $channelInfo = $this->youtubeApi->getChannelInfo($request);

                $this->storage->add([
                    'index' => 'youtube_channel',
                    'id'    => $channelInfo['ID'],
                    'body'  => $channelInfo
                ]);

                echo "<pre>";
                print_r($channelInfo);

                $videos = $this->youtubeApi->getChannelVideosInfo($channelInfo['ID']);

                print_r($videos);
                exit;


                Response::success('Channel successfully added.');
                break;
        }

    }
}
