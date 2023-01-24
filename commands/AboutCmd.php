<?php

class AboutCmd extends BaseCmd
{
    /**
     * About me (info)
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        $myYears  = floor((time() - strtotime($this->config['me']['birth_date']))  / (3600 * 24 * 365));
        $mskYears = floor((time() - strtotime($this->config['me']['in_msk_date'])) / (3600 * 24 * 365));

        $reply = $this->bot->getQB()->getInfo('about');
        $reply = str_replace(['%MY_YEARS', '%MSK_YEARS%'], [$myYears, $mskYears], $reply);

        $this->bot->sendMsg($reply);

        return true;
    }
}