<?php

/**
 * Bot commands list
 * @see https://www.cyberforum.ru/php-api/thread2273238.html
 */

require_once('vendor/autoload.php');

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Api;

class ExecCommand extends Command
{
    protected $name = "exec";
    protected $description = "Запуск бота";

    /**
     * @return void
     */
    public function handle()
    {
        $greeting = "Бот приветствует вас!";
        $this->replyWithMessage(['text' => $greeting]);
    }
}

