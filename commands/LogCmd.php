<?php

class LogCmd extends BaseCmd
{
    /**
     * Show bot dev log
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        $html = file_get_contents($this->config['common']['work_file']);

        $this->bot->sendMsg($html);

        return true;
    }
}