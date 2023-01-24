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
        $msgText = $this->bot->getMsg()->getText();
        $keywordPos = strpos($msgText, ' ');
        $userKeyword = $keywordPos ? substr($msgText, $keywordPos + 1) : '';
        $userKeyword = preg_replace('/\s+/', ',', $userKeyword);

        if(!$this->config['youtube']['search_keywords']) {
            throw new \Exception('Не заданы ключевые слова для поиска видео в конфиге: youtube.search_keywords');
        }

        $yotubeApi = new MyYoutubeApi();
        $url = $yotubeApi->searchRandomVideo($this->config['youtube']['search_keywords'] . ($userKeyword ? ',' . $userKeyword: ''));

        $this->bot->sendHtmlMsg($url);

        $html = "(*) Можно найти видео с указанным ключевым словом: \n/video поисковый_текст , например: /video ВДНХ";
        $this->bot->sendMsg($html);

        return true;
    }
}