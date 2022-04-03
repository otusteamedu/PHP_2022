<?php

namespace KonstantinDmitrienko\App;

/**
 *
 */
class App
{
    protected View              $view;
    protected ElasticSearch     $storage;
    protected YoutubeApiHandler $youtubeApi;
    protected Statistics        $statistics;

    public const CHANNEL_INDEX = 'youtube_channel';
    public const VIDEO_INDEX   = 'youtube_video';

    public function __construct() {
        $this->view       = new View();
        $this->youtubeApi = new YoutubeApiHandler();
        $this->storage    = new ElasticSearch();
        $this->statistics = new Statistics();
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
            case 'get_channels':
                $channels = $this->statistics->getAllChannelsInfo($this->storage);
                $response = [];
                foreach ($channels as $channel) {
                    $likes    = $this->statistics->getLikesCountInChannelVideos($this->storage, $channel['ID']);
                    $dislikes = $this->statistics->getDislikesCountInChannelVideos($this->storage, $channel['ID']);

                    $response[] = [
                        'Channel'       => $channel['Title'],
                        'LikesCount'    => $likes,
                        'DislikesCount' => $dislikes,
                    ];
                }

                Response::success(json_encode($response, JSON_PRETTY_PRINT));
                break;
            case 'get_top_rated_channels':
                $this->statistics->getTopRatedChannels($this->storage);
                Response::success(json_encode(
                    $this->statistics->getTopRatedChannels($this->storage),
                    JSON_PRETTY_PRINT)
                );
                break;
        }
    }

    protected function addYoutubeChannel($request): void
    {
        // Find saved channel in cache
        $cache = $this->storage->search([
            'index' => self::CHANNEL_INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'query' => $request['youtube']['name']
                    ]
                ]
            ]
        ]);

        if ($cache['hits']['total']['value']) {
            $channelInfo = $cache['hits']['hits'][0]['_source'];
        } else {
            $channelInfo = $this->youtubeApi->getChannelInfo($request);
            $channelInfo += ['query' => $request['youtube']['name']];

            // Save channel to cache
            $this->storage->add([
                'index' => self::CHANNEL_INDEX,
                'id'    => $channelInfo['ID'],
                'body'  => $channelInfo,
            ]);
        }

        $videos = $this->youtubeApi->getChannelVideosInfo($channelInfo['ID']);

        foreach ($videos as $video) {
            $video += ['ChannelID' => $channelInfo['ID']];

            $this->storage->add([
                'index' => self::VIDEO_INDEX,
                'id'    => $video['ID'],
                'body'  => $video,
            ]);
        }
    }
}
