<?php

namespace Ppro\Hw7;

use Ppro\Hw7\Helper\Conf;
use Ppro\Hw7\Helper\AppContext;


class App
{
    const DEFAULT_CONFIG_PATH = __DIR__."/../config.ini";
    private string $configPath;
    private AppContext $context;

    /**
     * @param string $customConfigPath
     * @throws \Exception
     */
    public function __construct(string $customConfigPath = "")
    {
        $this->configPath = $customConfigPath ?: self::DEFAULT_CONFIG_PATH;
        $this->initContext();
    }

    /** Запуск приложения
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $cmd = Commands\CommandResolver::getCommand();
        $cmd->execute($this->context);
    }

    /** Создание объекта конфигурации приложения
     * @return void
     * @throws \Exception
     */
    private function initContext():void
    {
        $this->context = new AppContext();
        $config = new Conf($this->configPath);
        $this->context->setValue('client',$config->getValue('socket','client'));
        $this->context->setValue('server',$config->getValue('socket','server'));
    }
}