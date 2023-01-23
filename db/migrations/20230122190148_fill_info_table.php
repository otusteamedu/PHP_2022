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
        // other section should be here
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
