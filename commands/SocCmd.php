<?php

require_once('BaseCmd.php');

class SocCmd extends BaseCmd implements CmdInterface
{
    /**
     * Show social networks list
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        $reply = $this->bot->getQB()->getInfo('soc');

        $this->bot->sendMsg($reply);

        return true;
    }
}