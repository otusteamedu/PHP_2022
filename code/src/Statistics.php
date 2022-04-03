<?php

namespace KonstantinDmitrienko\App;

class Statistics
{
    protected array $videos = [];

    public function getChannelInfo($storage, $id)
    {
        $cache = $storage->search([
            'index' => App::CHANNEL_INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        '_id' => $id
                    ]
                ]
            ]
        ]);

        return $cache['hits']['hits'] ? $cache['hits']['hits'][0]['_source']['info'] : [];
    }

    public function getAllChannelsInfo($storage): array
    {
        $cache    = $storage->search(['index' => App::CHANNEL_INDEX, 'size' => 1000]);
        $channels = [];

        if ($cache['hits']['hits']) {
            foreach ($cache['hits']['hits'] as $hit) {
                if ($hit['_source']) {
                    $channels[] = $hit['_source'];
                }
            }
        }

        return $channels;
    }

    public function getLikesCountInChannelVideos($storage, $channelID)
    {
        $likes = 0;
        if ($videos = $this->getVideosFromChannel($storage, $channelID)) {
            foreach ($videos as $video) {
                $likes += $video['Likes'];
            }
        }

        return $likes;
    }

    public function getDislikesCountInChannelVideos($storage, $channelID)
    {
        $dislikes = 0;
        if ($videos = $this->getVideosFromChannel($storage, $channelID)) {
            foreach ($videos as $video) {
                $dislikes += $video['Dislikes'];
            }
        }

        return $dislikes;
    }

    public function getVideosFromChannel($storage, $channelID): array
    {
        $cache = $storage->search([
            'index' => App::VIDEO_INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'ChannelID' => $channelID
                    ]
                ]
            ]
        ]);

        $videos = [];
        if ($cache['hits']['total']['value']) {
            foreach ($cache['hits']['hits'] as $hit) {
                if ($hit['_source']) {
                    $videos[] = $hit['_source'];
                }
            }
        }

        return $videos;
    }

    public function getTopRatedChannels(ElasticSearch $storage, int $limit = 3): array
    {
        $channels = $this->getAllChannelsInfo($storage);

        if (!$channels) {
            return [];
        }

        foreach ($channels as &$channel) {
            $channel['LikesCount']    = $this->getLikesCountInChannelVideos($storage, $channel['ID']);
            $channel['DislikesCount'] = $this->getDislikesCountInChannelVideos($storage, $channel['ID']);
            $channel['Rating']        = ($channel['LikesCount'] ?: 1) / ($channel['DislikesCount'] ?: 1);
        }

        usort($channels, static fn($a, $b) => $a['Rating'] < $b['Rating']);

        return array_slice($channels, 0, $limit);
    }
}
