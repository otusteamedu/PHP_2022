<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FillInfoTable extends AbstractMigration
{
    private $info  = [
        'soc' => "<b>Мои блоги со статьями:</b> \n" .
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
                "&#127758; Тамблр: https://mishaikon.tumblr.com/ \n",
        'help' => "Выберите нужную команду: \n\n" .
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
                "&#128233; /msg текст - отослать мне анонимное сообщение/отзыв \n",
        'about' => "&#128075; Я Михаил. Рад знакомству ) \n" .
                "Мне %MY_YEARS% лет. \n" .
                "&#128118; Родился в Челябинске. \n" .
                "&#127970; Живу и работаю в Москве, последние %MSK_YEARS% лет. \n" .
                "&#128187; Работаю веб-программистом. \n" .
                "&#127758; Мой технический блог по IT: www.nujensait.ru \n" .
                "&#9992; Люблю путешествия, спорт, блоггинг (как хобби). \n" .
                "&#128221; Мой блог об активном отдыхе и тревеле: www.mishaikon.ru \n" .
                "&#9997; Также пишу заметки о жизни в соцсетях, их список тут: /soc \n" .
                "&#128466; Почитать мои свежие заметки вы можете набрав команду /news \n" .
                "&#128223; Вы можете написать мне сообщение выбрав команду /msg текст_сообщения \n" .
                "&#128587; Будем знакомы )",
        'start' => "Приветствую, %NAME%! &#128587; \n" .
                 "Меня зовут Михаил, и это мой бот-помощник, &#129302; который поможет узнать обо мне больше.",
    ];

    /**
     * Do migration
     * @return void
     */
    public function up()
    {
        foreach($this->info as $section => $text) {
            $sql = "INSERT INTO `bot_info` 
                    (`section`, `text`)
                    VALUES ('{$section}', '{$text}')";

            $this->execute($sql);
        }
    }

    /**
     * Rollback
     * @return void
     */
    public function down()
    {
        $sql = "DELETE FROM `bot_info`;";
        $this->execute($sql);
    }
}
