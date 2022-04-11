<?php

namespace KonstantinDmitrienko\App\Models;

use KonstantinDmitrienko\App\Controllers\ElasticSearchController;

class Statistics
{
    /**
     * @param ElasticSearchController $elasticSearchController
     *
     * @return array
     */
    protected function getAllChannelsInfo(ElasticSearchController $elasticSearchController): array
    {
        $channels = [];
        foreach ($elasticSearchController->getAllChannelsInfo() as $channel) {
            $likes    = $this->getLikesCountInChannelVideos($elasticSearchController, $channel['ID']);
            $dislikes = $this->getDislikesCountInChannelVideos($elasticSearchController, $channel['ID']);

            $channels[] = [
                'Channel'       => $channel['Title'],
                'LikesCount'    => $likes,
                'DislikesCount' => $dislikes,
            ];
        }

        return $channels;
    }

    /**
     * @param ElasticSearchController $elasticSearchController
     * @param int                     $limit
     *
     * @return array
     */
    protected function getTopRatedChannels(ElasticSearchController $elasticSearchController, int $limit = 3): array
    {
        if (!($channels = $this->getAllChannelsInfo($elasticSearchController))) {
            return [];
        }

        foreach ($channels as &$channel) {
            $channel['Rating'] = ($channel['LikesCount'] ?: 1) / ($channel['DislikesCount'] ?: 1);
        }

        usort($channels, static fn($a, $b) => $a['Rating'] < $b['Rating']);

        return array_slice($channels, 0, $limit);
    }

    /**
     * @param ElasticSearchController $elasticSearchController
     * @param                         $channelID
     *
     * @return int
     */
    private function getLikesCountInChannelVideos(ElasticSearchController $elasticSearchController, $channelID): int
    {
        $likes = 0;
        foreach ($elasticSearchController->getVideosFromChannel($channelID) as $video) {
            $likes += (int) $video['Likes'];
        }

        return $likes;
    }

    /**
     * @param ElasticSearchController $elasticSearchController
     * @param                         $channelID
     *
     * @return int
     */
    private function getDislikesCountInChannelVideos(ElasticSearchController $elasticSearchController, $channelID): int
    {
        $dislikes = 0;
        foreach ($elasticSearchController->getVideosFromChannel($channelID) as $video) {
            $dislikes += (int) $video['Dislikes'];
        }

        return $dislikes;
    }
}
