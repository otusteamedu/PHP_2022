<?php

/**
 * Bot @mishaikon_bot
 */
class MishaikonChatBot extends BloggerChatBot
{
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /// ACTIONS

    /**
     * Show social networks list
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actSoc(): bool
    {
        $reply = "<b>Мои блоги со статьями:</b> \n" .
            "&#127758; Основной блог (фото/видео/заметки): http://www.mishaikon.ru \n" .
            "&#127758; Живой Журнал (копия блога): https://mishaikon.livejournal.com/ \n" .
            "&#127758; Яндекс-дзен: https://zen.yandex.ru/user/13791326 \n" .
            "&#127758; Блог о программировании и IT: http://www.nujensait.ru \n\n" .
            "<b>Все мои видео-ролики</b>: \n" .
            "&#127909; Ютуб: https://youtube.com/c/mishaikon \n" .
            "&#127909; ТикТок: https://www.tiktok.com/@mishaikon \n\n" .
            "<b>Мои основные соцсети:</b> \n" .
            "&#128248; Вконтакте: https://vk.com/mishaikon \n" .
            "&#128248; Телеграм канал: https://t.me/mishaikon_vlog \n" .
            "&#128248; Инстаграм: http://instagram.com/mishaikon \n\n" .
            "<b>Мои доп. соцсети</b> (копии постов): \n" .
            "&#127758; Фейсбук: http://www.facebook.com/mishaikon \n" .
            "&#127758; Одноклассники: https://ok.ru/profile/90610013839 \n" .
            "&#127758; Твиттер: http://twitter.com/mishaikon \n" .
            "&#127758; Тамблр: https://mishaikon.tumblr.com/ \n";

        $this->sendMsg($reply);

        return true;
    }

    /**
     * Start action
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actStart(): bool
    {
        $name = $this->msg->getFromUsername();            // Юзернейм пользователя

        $reply = "Приветствую, {$name}! &#128587; \n" .
                 "Меня зовут Михаил, и это мой бот-помощник, &#129302; который поможет узнать обо мне больше.";

        $this->sendMsg($reply);

        return $this->actHelp();
    }

    /**
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     * @see unicode symbols https://unicode-table.com/ru/1F30D/
     */
    protected function actHelp(): bool
    {
        $reply = "Выберите нужную команду: \n\n" .
            "&#9654; /start - приветствие \n\n" .
            "&#128657; /help - помощь \n\n" .
            "&#128129; /about - обо мне \n\n" .
            "&#127757; /soc - мои сайты и соцсети (список) \n\n" .
            "&#128240; /news - свежие посты из моего блога www.mishaikon.ru\n\n" .
            "&#128240; /itnews - новости из моего IT-блога www.nujensait.ru\n\n" .
            "&#128240; /subscr - подписка на новости\n\n" .
            "&#128235; /unsubscr - отписка от новостей\n\n" .
            "&#128248; /pic - случайная фотография из моего фото-архива\n\n" .
            "&#128249; /video - мое случайное видео из Youtube\n\n" .
            "&#129302; /log - новости/история разработки бота\n\n" .
            "&#128233; /msg текст - отослать мне анонимное сообщение/отзыв \n";

        $this->sendMsg($reply);

        return true;
    }

    /**
     * About me (info)
     * @return bool
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    protected function actAbout(): bool
    {
        $myYears = floor((time() - strtotime($this->config['me']['birth_date'])) / (3600 * 24 * 365));
        $mskYears = floor((time() - strtotime($this->config['me']['in_msk_date'])) / (3600 * 24 * 365));

        $reply = "&#128075; Я Михаил. Рад знакомству ) \n" .
                "Мне {$myYears} лет. \n" .
                "&#128118; Родился в Челябинске. \n" .
                "&#127970; Живу и работаю в Москве, последние {$mskYears} лет. \n" .
                "&#128187; Работаю веб-программистом. \n" .
                "&#127758; Мой технический блог по IT: www.nujensait.ru \n" .
                "&#9992; Люблю путешествия, спорт, блоггинг (как хобби). \n" .
                "&#128221; Мой блог об активном отдыхе и тревеле: www.mishaikon.ru \n" .
                "&#9997; Также пишу заметки о жизни в соцсетях, их список тут: /soc \n" .
                "&#128466; Почитать мои свежие заметки вы можете набрав команду /news \n" .
                "&#128223; Вы можете написать мне сообщение выбрав команду /msg текст_сообщения \n" .
                "&#128587; Будем знакомы )";

        $this->sendMsg($reply);

        return true;
    }
}