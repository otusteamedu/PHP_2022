<?php

use Telegram\Bot\Keyboard\Keyboard;

class MenuCmd extends BaseCmd
{
    /**
     * @return bool
     */
    public function run(): bool
    {
        $keyboard = [];

        // read menu from .ni config. see [menu] section
        $sections = $this->config['menu'];
        foreach($sections as $sectionArr) {
            $menuArr = [];
            foreach($sectionArr as $menuItem) {
                $menuArr[] = $menuItem;
            }
            $keyboard[] = $menuArr;
        }

        $reply = "Выберите действие:";

        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);

        $this->bot->getTgApi()->sendMessage([
            'chat_id' => $this->bot->getMsg()->getChatId(),
            'text' => $reply,
            'reply_markup' => $reply_markup
        ]);

        return true;
    }
}