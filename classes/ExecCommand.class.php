<?php

require_once('vendor/autoload.php');

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Api;

class ExecCommand extends Command
{
    protected $name = "exec";
    protected $description = "Запуск бота";

    public function handle()
    {
        $greeting = "Бот приветствует вас!";
        $this->replyWithMessage(['text' => $greeting]);
    }
}

