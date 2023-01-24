<?php

class PicCmd extends BaseCmd
{
    /**
     * Print random picture
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        $photo = new BlogPhoto($this->config);
        $url = $photo->getRandomPhoto();
        $url = $photo->savePhoto($url);
        $url = \Telegram\Bot\FileUpload\InputFile::create($url); // @see https://qna.habr.com/q/906075

        $this->bot->getTgApi()->sendPhoto([
            'chat_id' => $this->bot->getMsg()->getChatId(),
            'photo' => $url,
            'caption' => ''
        ]);

        return true;
    }
}