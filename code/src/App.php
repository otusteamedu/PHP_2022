<?php

namespace Ppro\Hw12;

use Ppro\Hw12\Helpers\Conf;
use Ppro\Hw12\Helpers\AppContext;
use SevenEcks\Tableify\Tableify;


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
        echo $this->context->getValue('RESULT');
    }

    /** Создание объекта конфигурации приложения
     * @return void
     * @throws \Exception
     */
    private function initContext():void
    {
        $this->context = new AppContext();
        $config = new Conf($this->configPath);
        $this->context->setValueMulti([
          'host' => $config->getValue('db','host'),
          'port' => $config->getValue('db','port'),
        ]);
    }
}