<?php

class MsgCmd extends BaseCmd
{
    /**
     * Send msg to author
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function run(): bool
    {
        $msgQues    = strtok("\n");
        $userId     = $this->bot->getMsg()->getFromUserId();
        $userName   = $this->bot->getMsg()->getFromUserName();

        if($msgQues) {
            // to admin
            $msgMe = "Сообщение от пользователя @$userName (#$userId): \n" . $msgQues;  //  из чата #$chatId
            $this->bot->sendMeMsg($msgMe);
            // to user
            $msgText = "Спасибо, ваше сообщение успешно отправлено.";
            $this->bot->sendMsg($msgText);
        } else {
            // to user
            $msgText = "Напишите ваше сообщение в формате: \n/msg текст_сообщения";
            $this->bot->sendMsg($msgText);
        }

        return true;
    }
}