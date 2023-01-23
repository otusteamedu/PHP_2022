<?php

class NewsCmd extends BaseCmd
{
    protected $newsSection = 'blog_rss_url';

    /**
     * Read last rss news from site
     * @return string`
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function getRssNews(string $url): string
    {
        $html = simplexml_load_file($url);
        $cnt = 0;
        $reply = "";
        foreach ($html->channel->item as $item) {
            $reply .= "&#10687; <b>" . $item->title . "</b>" . " <a href='" . $item->link . "'>\xE2\x9E\xA1</a>\n\n";
            $cnt++;
            if ($cnt > $this->config['news']['posts_limit']) {
                break;
            }
        }

        return $reply;
    }

    /**
     * Show last news list
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        $news = $this->getRssNews($this->config['news'][$this->newsSection]);
        $this->bot->sendMsg($news);

        return true;
    }
}