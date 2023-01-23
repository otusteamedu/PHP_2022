<?php

class StartCmd extends BaseCmd
{
    /**
     * Start action
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        // Юзернейм пользователя
        $name = $this->bot->getMsg()->getFromUsername();

        $reply = $this->bot->getQB()->getInfo('start');
        $reply = str_replace(['%NAME%'], [$name], $reply);

        $this->bot->sendMsg($reply);

        return true;
    }
}