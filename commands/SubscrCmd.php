<?php

class SubscrCmd extends BaseCmd
{
    /**
     * Subscribe user
     * @return bool
     */
    public function run(): bool
    {
        $userId   = $this->bot->getMsg()->getFromUserId();
        $userName = $this->bot->getMsg()->getFromUserName();
        $botName  = $this->bot->getBotName();

        $subscr = new ChatBotSubscriber($botName, $userId, $userName);
        $ret = $subscr->doSubscribe();

        if($ret) {
            $this->bot->sendMsg('Подписка успешно выполнена.');
        } else {
            $this->bot->sendMsg('Вы уже подписаны.');
        }

        return $ret;
    }
}