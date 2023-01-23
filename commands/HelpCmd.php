<?php

class HelpCmd extends BaseCmd
{
    /**
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     * @see unicode symbols https://unicode-table.com/ru/1F30D/
     */
    public function run(): bool
    {
        $reply = $this->bot->getQB()->getInfo('help');

        $this->bot->sendMsg($reply);

        return true;
    }
}