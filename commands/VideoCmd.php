<?php

class VideoCmd extends BaseCmd
{
    /**
     * get random video from Youtube
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        if(!$this->config['youtube']['search_keywords']) {
            throw new \Exception('Не заданы ключевые слова для поиска видео в конфиге: youtube.search_keywords');
        }

        $yotubeApi = new MyYoutubeApi();
        $url = $yotubeApi->searchRandomVideo($this->config['youtube']['search_keywords']);

        $this->bot->sendHtmlMsg($url);

        return true;
    }
}