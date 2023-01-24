<?php

class DefaultCmd extends BaseCmd
{
    /**
     * Default messagges handler
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        if (!$this->bot->getMsg()->getText()) {
            $reply = "Отправьте сообщение.";
        } else if (substr($this->bot->getMsg()->getText(), 0, 1) === '/') {
            $reply = "Неизвестная команда: \"<b>" . $this->bot->getMsg()->getText() . "</b>\"";
        } else {
            $cmd = new HelpCmd($this->bot);
            return $cmd->run();
        }

        $this->bot->sendMsg($reply);

        return true;
    }

}