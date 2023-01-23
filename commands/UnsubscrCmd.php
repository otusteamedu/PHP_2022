<?php

class UnsubscrCmd extends BaseCmd
{
    /**
     * @return bool
     */
    public function run(): bool
    {
        $userId   = $this->bot->getMsg()->getFromUserId();
        $userName = $this->bot->getMsg()->getFromUserName();
        $botName  = $this->bot->getBotName();

        $subscr = new ChatBotSubscriber($botName, $userId, $userName);
        $ret = $subscr->doUnsubscribe();

        if($ret) {
            $this->bot->sendMsg('Отписка успешно выполнена.');
        } else {
            $this->bot->sendMsg('Вы не найдены среди подписчиков.');
        }

        return $ret;
    }
}