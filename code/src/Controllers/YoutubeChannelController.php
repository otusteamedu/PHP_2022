<?php

namespace KonstantinDmitrienko\App\Controllers;

use KonstantinDmitrienko\App\Models\YoutubeChannel;

class YoutubeChannelController extends YoutubeChannel
{
    /**
     * @param string $name
     *
     * @return array
     */
    public function getChannelInfo(string $name): array
    {
        $channelInfo = parent::getChannelInfo($name);
        $channelInfo += ['query' => $name];

        return $channelInfo;
    }

    /**
     * @param string $channelID
     *
     * @return array
     */
    public function getChannelVideosInfo(string $channelID): array
    {
        $videos = [];

        do {
            $videosInfo = $this->getBaseVideosInfo($channelID);

            foreach ($videosInfo['items'] as $item) {
                if (!$item['id']['videoId']) {
                    continue;
                }

                $videoInfo = $this->getVideoInfo($item['id']['videoId']);

                $videos[] = [
                    'ID'          => $item['id']['videoId'],
                    'Title'       => $item['snippet']['title'],
                    'Description' => $item['snippet']['description'],
                    'Likes'       => $videoInfo['items'][0]['statistics']['likeCount'],
                    'Dislikes'    => $videoInfo['items'][0]['statistics']['dislikeCount'],
                    'ChannelID'   => $channelID,
                ];
            }
        } while ($videosInfo['nextPageToken']);

        return $videos;
    }
}
