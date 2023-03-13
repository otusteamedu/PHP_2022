<?php

namespace Ppro\Hw27\Consumer\Application;

use Ppro\Hw27\Consumer\Commands\CommandResolver;

class App
{
    private Register $reg;

    /**
     * @param string $customConfigPath
     * @throws \Exception
     */
    public function __construct()
    {
        $this->init();
    }

    /** Запуск приложения
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $cmd = CommandResolver::getCommand();
        $cmd->execute();
    }

    /** Создание объекта конфигурации приложения
     * @return void
     * @throws \Exception
     */
    private function init():void
    {
        (new ApplicationHelper())->init();
    }
}